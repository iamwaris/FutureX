<?php

namespace Tests\Feature;

use App\Models\SnapshotStat;
use App\Models\StreamingCredential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SnapshotStatsSyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_command_pulls_enabled_fields_from_youtube(): void
    {
        StreamingCredential::create([
            'platform' => 'youtube',
            'channel_id' => 'UC12345',
            'client_id' => 'api-key',
            'is_enabled' => true,
        ]);

        SnapshotStat::current()->update([
            'sync_subscribers_from_youtube' => true,
            'sync_total_views_from_youtube' => true,
            'sync_videos_from_youtube' => false,
        ]);

        Http::fake([
            'www.googleapis.com/*' => Http::response(['items' => [[
                'statistics' => [
                    'subscriberCount' => '128400',
                    'viewCount' => '18500000',
                    'videoCount' => '940',
                ],
            ]]]),
        ]);

        $this->artisan('snapshot-stats:sync')->assertExitCode(0);

        $stats = SnapshotStat::current();
        $this->assertSame(128400, $stats->subscribers);
        $this->assertSame(18500000, $stats->total_views);
        // sync_videos_from_youtube was left off, so this stays at its default.
        $this->assertSame(0, $stats->videos_published);
        $this->assertNotNull($stats->last_synced_at);
    }

    public function test_sync_command_does_nothing_when_no_sync_flags_enabled(): void
    {
        SnapshotStat::current()->update(['subscribers' => 999]);

        $this->artisan('snapshot-stats:sync')->assertExitCode(0);

        $this->assertSame(999, SnapshotStat::current()->subscribers);
        $this->assertNull(SnapshotStat::current()->last_synced_at);
    }
}
