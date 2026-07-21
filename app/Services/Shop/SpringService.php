<?php

namespace App\Services\Shop;

use App\Models\ShopCredential;
use Illuminate\Support\Facades\Http;

/**
 * Spring (formerly Teespring) doesn't publish a simple public REST API for
 * arbitrary third-party product reads the way Shopify/WooCommerce/Gumroad
 * do — real integration typically requires an approved partner/OAuth
 * application. This follows Spring's general storefront API shape as a
 * best-effort implementation; verify the endpoint and response fields
 * against current Spring partner docs once real credentials are issued,
 * same as the Twitch-follower-sync caveat in SnapshotStat.
 */
class SpringService implements ShopProvider
{
    public function platformKey(): string
    {
        return 'spring';
    }

    public function isConfigured(): bool
    {
        $credential = $this->credential();

        return $credential?->is_enabled
            && filled($credential->store_url)
            && filled($credential->access_token);
    }

    public function fetchProducts(): array
    {
        $credential = $this->credential();

        if (! $credential) {
            return [];
        }

        $response = Http::withToken($credential->access_token)
            ->get("https://api.spri.ng/v1/stores/{$credential->store_url}/products");

        $products = $response->json('products', []);

        return collect($products)->map(fn (array $product) => new ShopProduct(
            name: $product['name'] ?? $product['title'] ?? 'Untitled',
            priceFormatted: isset($product['price']) ? '$'.number_format((float) $product['price'], 2) : '',
            productUrl: $product['url'] ?? '#',
            imageUrl: $product['image_url'] ?? null,
        ))->all();
    }

    private function credential(): ?ShopCredential
    {
        return ShopCredential::forPlatform($this->platformKey());
    }
}
