<?php

namespace App\Services\Shop;

use Illuminate\Support\Facades\URL;

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

    /**
     * A signed /shop/out link that logs a ProductClick before redirecting —
     * signed so the redirect target can't be tampered with (see routes/web.php).
     */
    public function trackedUrl(): string
    {
        return URL::signedRoute('shop.out', [
            'url' => $this->productUrl,
            'name' => $this->name,
        ]);
    }
}
