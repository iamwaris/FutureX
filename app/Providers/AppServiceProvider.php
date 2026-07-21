<?php

namespace App\Providers;

use App\Services\LiveStatus\KickService;
use App\Services\LiveStatus\LiveStatusManager;
use App\Services\LiveStatus\TwitchService;
use App\Services\LiveStatus\YouTubeLiveService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LiveStatusManager::class, fn () => new LiveStatusManager([
            new TwitchService(),
            new KickService(),
            new YouTubeLiveService(),
        ]));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
