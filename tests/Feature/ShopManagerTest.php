<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ShopCredential;
use App\Services\Shop\ShopManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ShopManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_falls_back_to_manual_products_when_no_provider_is_active(): void
    {
        Product::factory()->create(['name' => 'Manual Hoodie', 'is_featured' => true]);

        $products = app(ShopManager::class)->products();

        $this->assertCount(1, $products);
        $this->assertSame('Manual Hoodie', $products[0]->name);
    }

    /**
     * The core M8 exit criteria: switching the active shop provider in
     * Filament changes what renders on /shop without code changes.
     */
    public function test_switching_the_active_provider_changes_the_rendered_products(): void
    {
        Product::factory()->create(['name' => 'Manual Fallback Product', 'is_featured' => true]);

        $gumroad = ShopCredential::create([
            'platform' => 'gumroad',
            'access_token' => 'gumroad-token',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.gumroad.com/*' => Http::response(['products' => [
                ['name' => 'Gumroad Product', 'formatted_price' => '$5', 'short_url' => '#'],
            ]]),
        ]);

        // Nothing active yet — manual fallback.
        $products = app(ShopManager::class)->products();
        $this->assertSame('Manual Fallback Product', $products[0]->name);

        // Activate Gumroad — /shop should now show Gumroad's products.
        $gumroad->activate();
        $products = app(ShopManager::class)->products();
        $this->assertSame('Gumroad Product', $products[0]->name);

        $woocommerce = ShopCredential::create([
            'platform' => 'woocommerce',
            'store_url' => 'https://example.com',
            'access_token' => 'ck_test',
            'api_secret' => 'cs_test',
            'is_enabled' => true,
        ]);

        Http::fake([
            'api.gumroad.com/*' => Http::response(['products' => [
                ['name' => 'Gumroad Product', 'formatted_price' => '$5', 'short_url' => '#'],
            ]]),
            'example.com/*' => Http::response([
                ['name' => 'WooCommerce Product', 'price' => '10.00', 'permalink' => '#', 'images' => []],
            ]),
        ]);

        // Switch active provider to WooCommerce — output changes again,
        // with zero code changes, just a Filament action.
        $woocommerce->activate();
        $products = app(ShopManager::class)->products();
        $this->assertSame('WooCommerce Product', $products[0]->name);
    }

    public function test_saving_a_product_invalidates_the_cache(): void
    {
        $product = Product::factory()->create(['name' => 'Original Name', 'is_featured' => true]);

        $products = app(ShopManager::class)->products();
        $this->assertSame('Original Name', $products[0]->name);

        $product->update(['name' => 'Updated Name']);

        $products = app(ShopManager::class)->products();
        $this->assertSame('Updated Name', $products[0]->name);
    }
}
