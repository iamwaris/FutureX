<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeSnapshot extends Model
{
    protected $fillable = [
        'active_mode',
        'theme_snapshot',
        'sections_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'theme_snapshot' => 'array',
            'sections_snapshot' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
