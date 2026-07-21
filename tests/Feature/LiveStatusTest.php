<?php

namespace Tests\Feature;

use App\Models\StreamingCredential;
use App\Services\LiveStatus\KickService;
use App\Services\LiveStatus\LiveStatusManager;
use App\Services\LiveStatus\TwitchService;
use App\Services\LiveStatus\YouTubeLiveService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LiveStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_twitch_service_reports_offline_when_no_stream_data_returned(): void
    {
        StreamingCredential::create([
            'platform' => 'twitch',
            'channel_id' => '12345',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'is_enabled' => true,
        ]);

        Http::fake([
            'id.twitch.tv/*' => Http::response(['access_token' => 'token', 'expires_in' => 3600]),
            'api.twitch.tv/*' => Http::response(['data' => []]),
        ]);

        $status = (new TwitchService())->fetchStatus();

        $this->assertFalse($status->isLive);
        $this->assertSame('twitch', $status->platform);
    }

    public function test_twitch_service_parses_a_live_stream_response(): void
    {
        StreamingCredential::create([
            'platform' => 'twitch',
            'channel_id' => '12345',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'is_enabled' => true,
        ]);

        Http::fake([
            'id.twitch.tv/*' => Http::response(['access_token' => 'token', 'expires_in' => 3600]),
            'api.twitch.tv/*' => Http::response(['data' => [[
                'title' => 'Ranked grind',
                'game_name' => 'Valorant',
                'viewer_count' => 250,
                'started_at' => '2026-07-21T10:00:00Z',
                'user_login' => 'examplecreator',
            ]]]),
        ]);

        $status = (new TwitchService())->fetchStatus();

        $this->assertTrue($status->isLive);
        $this->assertSame('Ranked grind', $status->title);
        $this->assertSame('Valorant', $status->category);
        $this->assertSame(250, $status->viewerCount);
        $this->assertSame('https://twitch.tv/examplecreator', $status->watchUrl);
    }

    public function test_youtube_service_reports_offline_when_no_live_video_found(): void
    {
        StreamingCredential::create([
            'platform' => 'youtube',
            'channel_id' => 'UC12345',
            'client_id' => 'api-key',
            'is_enabled' => true,
        ]);

        Http::fake([
            'www.googleapis.com/*' => Http::response(['items' => []]),
        ]);

        $status = (new YouTubeLiveService())->fetchStatus();

        $this->assertFalse($status->isLive);
    }

    public function test_manager_caches_the_first_live_provider_and_falls_back_to_offline(): void
    {
        // Nothing configured at all — should cache an explicit offline status.
        $manager = new LiveStatusManager([
            new TwitchService(),
            new KickService(),
            new YouTubeLiveService(),
        ]);

        $status = $manager->refresh();

        $this->assertFalse($status->isLive);
        $this->assertSame($status->platform, $manager->current()->platform);
    }

    public function test_manager_skips_unconfigured_providers(): void
    {
        StreamingCredential::create([
            'platform' => 'twitch',
            'channel_id' => '12345',
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'is_enabled' => true,
        ]);

        Http::fake([
            'id.twitch.tv/*' => Http::response(['access_token' => 'token', 'expires_in' => 3600]),
            'api.twitch.tv/*' => Http::response(['data' => [[
                'title' => 'Live now',
                'game_name' => 'Just Chatting',
                'viewer_count' => 42,
                'started_at' => '2026-07-21T10:00:00Z',
                'user_login' => 'examplecreator',
            ]]]),
        ]);

        // Kick/YouTube have no credentials at all, so the manager should
        // skip straight to Twitch without erroring on missing config.
        $manager = new LiveStatusManager([
            new KickService(),
            new YouTubeLiveService(),
            new TwitchService(),
        ]);

        $status = $manager->refresh();

        $this->assertTrue($status->isLive);
        $this->assertSame('twitch', $status->platform);
    }
}
