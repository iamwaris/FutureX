<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSetting extends Model
{
    protected $fillable = [
        'provider',
        'api_key',
        'list_id',
        'is_enabled',
    ];

    protected function casts(): array
    {
        return [
            'api_key' => 'encrypted',
            'is_enabled' => 'boolean',
        ];
    }

    public static function current(): self
    {
        $instance = static::query()->firstOrCreate(['id' => 1]);

        if ($instance->wasRecentlyCreated) {
            $instance->refresh();
        }

        return $instance;
    }
}
