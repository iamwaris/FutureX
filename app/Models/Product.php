<?php

namespace App\Models;

use App\Services\Shop\ShopManager;
use App\Services\Shop\ShopProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'price',
        'product_url',
        'is_featured',
        'is_limited_drop',
        'is_digital_download',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_limited_drop' => 'boolean',
            'is_digital_download' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function toShopProduct(): ShopProduct
    {
        return new ShopProduct(
            name: $this->name,
            priceFormatted: '$'.number_format((float) $this->price, 2),
            productUrl: $this->product_url ?? '#',
            imageUrl: $this->getFirstMediaUrl('image') ?: null,
            isLimited: $this->is_limited_drop,
            isDigital: $this->is_digital_download,
        );
    }

    protected static function booted(): void
    {
        static::saved(fn () => app(ShopManager::class)->forgetCache());
        static::deleted(fn () => app(ShopManager::class)->forgetCache());
    }
}
