<?php

namespace App\Services\Shop;

use App\Models\ShopCredential;
use Illuminate\Support\Facades\Http;

/**
 * Uses Fourthwall's public Storefront API (storefront-api.fourthwall.com) —
 * store_url isn't needed here, just the storefront token.
 */
class FourthwallService implements ShopProvider
{
    public function platformKey(): string
    {
        return 'fourthwall';
    }

    public function isConfigured(): bool
    {
        $credential = $this->credential();

        return $credential?->is_enabled && filled($credential->access_token);
    }

    public function fetchProducts(): array
    {
        $credential = $this->credential();

        if (! $credential) {
            return [];
        }

        $response = Http::get('https://storefront-api.fourthwall.com/v1/collections/all/products', [
            'storefront_token' => $credential->access_token,
        ]);

        $results = $response->json('results', []);

        return collect($results)->map(fn (array $product) => new ShopProduct(
            name: $product['name'],
            priceFormatted: isset($product['unitPrice'])
                ? number_format((float) $product['unitPrice']['amount'], 2).' '.$product['unitPrice']['currency']
                : '',
            productUrl: isset($product['slug']) ? "https://{$credential->store_url}/products/{$product['slug']}" : '#',
            imageUrl: $product['images'][0]['url'] ?? null,
        ))->all();
    }

    private function credential(): ?ShopCredential
    {
        return ShopCredential::forPlatform($this->platformKey());
    }
}
