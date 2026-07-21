<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamingCredential extends Model
{
    protected $fillable = [
        'platform',
        'channel_id',
        'client_id',
        'client_secret',
        'cached_access_token',
        'cached_access_token_expires_at',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'client_secret' => 'encrypted',
            'cached_access_token' => 'encrypted',
            'cached_access_token_expires_at' => 'datetime',
            'is_enabled' => 'boolean',
        ];
    }

    public static function forPlatform(string $platform): ?self
    {
        return static::query()->where('platform', $platform)->first();
    }
}
