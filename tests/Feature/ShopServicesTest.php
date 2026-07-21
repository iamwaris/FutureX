<?php

namespace Tests\Feature;

use App\Models\ShopCredential;
use App\Services\Shop\FourthwallService;
use App\Services\Shop\GumroadService;
use App\Services\Shop\ShopifyService;
use App\Services\Shop\SpringService;
use App\Services\Shop\WooCommerceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ShopServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_shopify_service_parses_products(): void
    {
        ShopCredential::create([
            'platform' => 'shopify',
            'store_url' => 'example.myshopify.com',
            'access_token' => 'token',
            'is_enabled' => true,
        ]);

        Http::fake([
            'example.myshopify.com/*' => Http::response(['data' => ['products' => ['edges' => [
                ['node' => [
                    'title' => 'Signature Hoodie',
                    'onlineStoreUrl' => 'https://example.myshopify.com/products/hoodie',
                    'priceRange' => ['minVariantPrice' => ['amount' => '58.00', 'currencyCode' => 'USD']],
                    'images' => ['edges' => [['node' => ['url' => 'https://cdn.example.com/hoodie.jpg']]]],
                ]],
            ]]]]),
        ]);

        $products = (new ShopifyService())->fetchProducts();

        $this->assertCount(1, $products);
        $this->assertSame('Signature Hoodie', $products[0]->name);
        $this->assertSame('58.00 USD', $products[0]->priceFormatted);
        $this->assertSame('https://cdn.example.com/hoodie.jpg', $products[0]->imageUrl);
    }

    public function test_fourthwall_service_parses_products(): void
    {
        ShopCredential::create([
            'platform' => 'fourthwall',
            'store_url' => 'example.com',
            'access_token' => 'storefront-token',
            'is_enabled' => true,
        ]);

        Http::fake([
            'storefront-api.fourthwall.com/*' => Http::response(['results' => [
                [
                    'name' => 'Logo Tee',
                    'unitPrice' => ['amount' => 28, 'currency' => 'USD'],
                    'slug' => 'logo-tee',
                    'images' => [['url' => 'https://cdn.example.com/tee.jpg']],
                ],
            ]]),
        ]);

        $products = (new FourthwallService())->fetchProducts();

        $this->assertCount(1, $products);
        $this->assertSame('Logo Tee', $products[0]->name);
        $this->assertSame('https://example.com/products/logo-tee', $products[0]->productUrl);
    }

    public function test_woocommerce_service_parses_products(): void
    {
        ShopCredential::create([
            'platform' => 'woocommerce',
            'store_url' => 'https://example.com',
            'access_token' => 'ck_test',
            'api_secret' => 'cs_test',
            'is_enabled' => true,
        ]);

        Http::fake([
            'example.com/*' => Http::response([
                [
                    'name' => 'Desk Mat',
                    'price' => '22.00',
                    'permalink' => 'https://example.com/product/desk-mat',
                    'images' => [['src' => 'https://cdn.example.com/mat.jpg']],
                    'virtual' => false,
                ],
            ]),
        ]);

        $products = (new WooCommerceService())->fetchProducts();

        $this->assertCount(1, $products);
        $this->assertSame('Desk Mat', $products[0]->name);
        $this->assertSame('$22.00', $products[0]->priceFormatted);
        $this->assertFalse($products[0]->isDigital);
    }

    public function test_gumroad_service_parses_products_as_digital(): void
    {
        ShopCredential::create([
            'platform' => 'gumroad',
            'access_token' => 'gumroad-token',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.gumroad.com/*' => Http::response(['products' => [
                ['name' => 'Emote Pack', 'formatted_price' => '$5', 'short_url' => 'https://gum.co/emotes', 'preview_url' => 'https://cdn.example.com/emotes.jpg'],
            ]]),
        ]);

        $products = (new GumroadService())->fetchProducts();

        $this->assertCount(1, $products);
        $this->assertTrue($products[0]->isDigital);
    }

    public function test_spring_service_parses_products(): void
    {
        ShopCredential::create([
            'platform' => 'spring',
            'store_url' => 'example-store',
            'access_token' => 'spring-token',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.spri.ng/*' => Http::response(['products' => [
                ['name' => 'Poster', 'price' => 15, 'url' => 'https://spri.ng/example/poster'],
            ]]),
        ]);

        $products = (new SpringService())->fetchProducts();

        $this->assertCount(1, $products);
        $this->assertSame('Poster', $products[0]->name);
        $this->assertSame('$15.00', $products[0]->priceFormatted);
    }
}
