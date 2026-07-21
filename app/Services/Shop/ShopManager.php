<?php

namespace App\Services\Shop;

use App\Models\Product;
use App\Models\ShopCredential;
use Illuminate\Support\Facades\Cache;

class ShopManager
{
    private const CACHE_KEY = 'shop:products';

    /**
     * @param  array<string, ShopProvider>  $providers  keyed by platformKey()
     */
    public function __construct(private readonly array $providers)
    {
    }

    /**
     * @return ShopProduct[]
     */
    public function products(): array
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(10), function () {
            $active = ShopCredential::active();
            $provider = $active ? ($this->providers[$active->platform] ?? null) : null;

            if ($provider?->isConfigured()) {
                $products = $provider->fetchProducts();

                if (! empty($products)) {
                    return $products;
                }
            }

            // No active provider, or it returned nothing (unconfigured,
            // API error, or a genuinely empty store) — fall back to
            // whatever the admin has manually curated.
            return Product::query()
                ->where('is_featured', true)
                ->ordered()
                ->get()
                ->map(fn (Product $product) => $product->toShopProduct())
                ->all();
        });
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
