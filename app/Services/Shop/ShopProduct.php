<?php

namespace App\Services\Shop;

final readonly class ShopProduct
{
    public function __construct(
        public string $name,
        public string $priceFormatted,
        public string $productUrl,
        public ?string $imageUrl = null,
        public bool $isLimited = false,
        public bool $isDigital = false,
    ) {
    }
}
