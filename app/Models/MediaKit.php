<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaKit extends Model
{
    protected $fillable = [
        'bio',
        'brand_values',
        'avg_viewers',
        'peak_viewers',
        'monthly_impressions',
        'age_ranges',
        'gender_distribution',
        'languages',
        'geographic_breakdown',
    ];

    protected function casts(): array
    {
        return [
            'brand_values' => 'array',
            'age_ranges' => 'array',
            'gender_distribution' => 'array',
            'languages' => 'array',
            'geographic_breakdown' => 'array',
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
