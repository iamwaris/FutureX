<?php

namespace App\Providers;

use App\Services\LiveStatus\KickService;
use App\Services\LiveStatus\LiveStatusManager;
use App\Services\LiveStatus\TwitchService;
use App\Services\LiveStatus\YouTubeLiveService;
use App\Services\Shop\FourthwallService;
use App\Services\Shop\GumroadService;
use App\Services\Shop\ShopifyService;
use App\Services\Shop\ShopManager;
use App\Services\Shop\SpringService;
use App\Services\Shop\WooCommerceService;
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

        $this->app->singleton(ShopManager::class, fn () => new ShopManager([
            'shopify' => new ShopifyService(),
            'fourthwall' => new FourthwallService(),
            'woocommerce' => new WooCommerceService(),
            'gumroad' => new GumroadService(),
            'spring' => new SpringService(),
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
