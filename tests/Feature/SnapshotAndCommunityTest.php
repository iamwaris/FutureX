<?php

namespace Tests\Feature;

use App\Models\CommunityLink;
use App\Models\PageSection;
use App\Models\SnapshotStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SnapshotAndCommunityTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_reflects_snapshot_stats_from_the_database(): void
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);

        SnapshotStat::current()->update(['followers' => 555000]);

        $this->get('/')->assertSee('data-counter-to="555000"', false);
    }

    public function test_homepage_shows_the_primary_community_link_as_spotlight(): void
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);

        CommunityLink::create([
            'platform' => 'discord', 'label' => 'Discord', 'stat_label' => '99,000 members',
            'url' => 'https://discord.gg/example', 'is_primary' => true, 'order' => 0,
        ]);
        CommunityLink::create([
            'platform' => 'youtube', 'label' => 'YouTube', 'stat_label' => '1,000 subscribers',
            'url' => 'https://youtube.com/example', 'is_primary' => false, 'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertSee('99,000 members');
        $response->assertSee('1,000 subscribers');
    }
}
