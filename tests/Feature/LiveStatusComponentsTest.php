<?php

namespace Tests\Feature;

use App\Livewire\HeroLiveStatus;
use App\Livewire\LiveStatusBanner;
use App\Livewire\NavLiveIndicator;
use App\Services\LiveStatus\LiveStatusManager;
use App\Services\LiveStatus\LiveStreamStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Tests\TestCase;

class LiveStatusComponentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_components_show_offline_state_by_default(): void
    {
        Livewire::test(LiveStatusBanner::class)->assertSee('Currently Offline');
        Livewire::test(NavLiveIndicator::class)->assertSee('OFFLINE');
        Livewire::test(HeroLiveStatus::class)->assertSee('OFFLINE');
    }

    public function test_components_reflect_a_cached_live_status(): void
    {
        Cache::put(LiveStatusManager::CACHE_KEY, new LiveStreamStatus(
            platform: 'twitch',
            isLive: true,
            title: 'Ranked grind → road to Radiant',
            category: 'Valorant',
            viewerCount: 3204,
        ));

        Livewire::test(LiveStatusBanner::class)
            ->assertSee('LIVE NOW')
            ->assertSee('Ranked grind → road to Radiant')
            ->assertSee('3,204 viewers');

        Livewire::test(NavLiveIndicator::class)->assertSee('LIVE');

        Livewire::test(HeroLiveStatus::class)
            ->assertSee('LIVE')
            ->assertSee('3,204 watching');
    }
}
