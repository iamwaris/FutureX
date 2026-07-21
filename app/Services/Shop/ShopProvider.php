<?php

namespace App\Services\Shop;

interface ShopProvider
{
    /**
     * The value stored in shop_credentials.platform for this provider.
     */
    public function platformKey(): string;

    public function isConfigured(): bool;

    /**
     * @return ShopProduct[]
     */
    public function fetchProducts(): array;
}
