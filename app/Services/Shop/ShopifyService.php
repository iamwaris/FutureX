<?php

namespace App\Services\Shop;

use App\Models\ShopCredential;
use Illuminate\Support\Facades\Http;

/**
 * Uses Shopify's Storefront GraphQL API — store_url is the
 * *.myshopify.com domain, access_token is a Storefront API access
 * token (not an Admin API key; those are different tokens).
 */
class ShopifyService implements ShopProvider
{
    public function platformKey(): string
    {
        return 'shopify';
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

        $query = <<<'GRAPHQL'
            {
              products(first: 20) {
                edges {
                  node {
                    title
                    onlineStoreUrl
                    priceRange { minVariantPrice { amount currencyCode } }
                    images(first: 1) { edges { node { url } } }
                  }
                }
              }
            }
        GRAPHQL;

        $response = Http::withHeaders([
            'X-Shopify-Storefront-Access-Token' => $credential->access_token,
            'Content-Type' => 'application/json',
        ])->post("https://{$credential->store_url}/api/2024-01/graphql.json", ['query' => $query]);

        $edges = $response->json('data.products.edges', []);

        return collect($edges)->map(function (array $edge) {
            $node = $edge['node'];
            $price = $node['priceRange']['minVariantPrice'] ?? null;

            return new ShopProduct(
                name: $node['title'],
                priceFormatted: $price ? number_format((float) $price['amount'], 2).' '.$price['currencyCode'] : '',
                productUrl: $node['onlineStoreUrl'] ?? '#',
                imageUrl: $node['images']['edges'][0]['node']['url'] ?? null,
            );
        })->all();
    }

    private function credential(): ?ShopCredential
    {
        return ShopCredential::forPlatform($this->platformKey());
    }
}
