<?php

namespace App\Services\Shop;

use App\Models\ShopCredential;
use Illuminate\Support\Facades\Http;

/**
 * Uses the WooCommerce REST API — store_url is the site's base URL,
 * access_token/api_secret are the consumer key/secret (Basic Auth).
 */
class WooCommerceService implements ShopProvider
{
    public function platformKey(): string
    {
        return 'woocommerce';
    }

    public function isConfigured(): bool
    {
        $credential = $this->credential();

        return $credential?->is_enabled
            && filled($credential->store_url)
            && filled($credential->access_token)
            && filled($credential->api_secret);
    }

    public function fetchProducts(): array
    {
        $credential = $this->credential();

        if (! $credential) {
            return [];
        }

        $response = Http::withBasicAuth($credential->access_token, $credential->api_secret)
            ->get(rtrim($credential->store_url, '/').'/wp-json/wc/v3/products', [
                'per_page' => 20,
                'status' => 'publish',
            ]);

        return collect($response->json() ?? [])->map(fn (array $product) => new ShopProduct(
            name: $product['name'],
            priceFormatted: '$'.($product['price'] ?: '0.00'),
            productUrl: $product['permalink'] ?? '#',
            imageUrl: $product['images'][0]['src'] ?? null,
            isDigital: $product['virtual'] ?? false,
        ))->all();
    }

    private function credential(): ?ShopCredential
    {
        return ShopCredential::forPlatform($this->platformKey());
    }
}
