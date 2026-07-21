<?php

namespace Tests\Feature;

use App\Models\ProductClick;
use App\Services\Shop\ShopProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductClickTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_signed_tracked_url_logs_a_click_and_redirects_to_the_real_destination(): void
    {
        $product = new ShopProduct(
            name: 'Signature Hoodie',
            priceFormatted: '$58.00',
            productUrl: 'https://real-store.example.com/hoodie',
        );

        $response = $this->get($product->trackedUrl());

        $response->assertRedirect('https://real-store.example.com/hoodie');
        $this->assertDatabaseHas('product_clicks', [
            'product_name' => 'Signature Hoodie',
            'destination_url' => 'https://real-store.example.com/hoodie',
        ]);
    }

    /**
     * Without signature verification, this would be an open redirect —
     * anyone could craft ?url=https://evil.example through our own domain.
     */
    public function test_a_tampered_url_is_rejected_and_does_not_log_a_click(): void
    {
        $response = $this->get('/shop/out?name=test&url=https://evil.example.com&signature=0000000000000000000000000000000000000000000000000000000000000000');

        $response->assertForbidden();
        $this->assertSame(0, ProductClick::count());
    }

    public function test_an_unsigned_request_is_rejected(): void
    {
        $response = $this->get('/shop/out?name=test&url=https://evil.example.com');

        $response->assertForbidden();
        $this->assertSame(0, ProductClick::count());
    }
}
