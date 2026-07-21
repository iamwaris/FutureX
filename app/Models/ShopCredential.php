<?php

namespace App\Models;

use App\Services\Shop\ShopManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShopCredential extends Model
{
    protected $fillable = [
        'platform',
        'store_url',
        'access_token',
        'api_secret',
        'is_active',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'access_token' => 'encrypted',
            'api_secret' => 'encrypted',
            'is_active' => 'boolean',
            'is_enabled' => 'boolean',
        ];
    }

    public static function forPlatform(string $platform): ?self
    {
        return static::query()->where('platform', $platform)->first();
    }

    public static function active(): ?self
    {
        return static::query()->where('is_active', true)->where('is_enabled', true)->first();
    }

    /**
     * Only one provider should be "live" at a time — activating this one
     * deactivates every other row in the same transaction.
     */
    public function activate(): void
    {
        DB::transaction(function () {
            static::query()->where('id', '!=', $this->id)->update(['is_active' => false]);
            $this->update(['is_active' => true]);
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => app(ShopManager::class)->forgetCache());
        static::deleted(fn () => app(ShopManager::class)->forgetCache());
    }
}
