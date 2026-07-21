<?php

namespace App\Services\Shop;

use App\Models\ShopCredential;
use Illuminate\Support\Facades\Http;

/**
 * Uses the Gumroad API — access_token is a Gumroad access token.
 * Everything sold through Gumroad is a digital download.
 */
class GumroadService implements ShopProvider
{
    public function platformKey(): string
    {
        return 'gumroad';
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

        $response = Http::get('https://api.gumroad.com/v2/products', [
            'access_token' => $credential->access_token,
        ]);

        $products = $response->json('products', []);

        return collect($products)->map(fn (array $product) => new ShopProduct(
            name: $product['name'],
            priceFormatted: $product['formatted_price'] ?? '',
            productUrl: $product['short_url'] ?? '#',
            imageUrl: $product['preview_url'] ?? null,
            isDigital: true,
        ))->all();
    }

    private function credential(): ?ShopCredential
    {
        return ShopCredential::forPlatform($this->platformKey());
    }
}
