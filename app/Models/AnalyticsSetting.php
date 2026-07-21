<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsSetting extends Model
{
    protected $fillable = [
        'ga4_measurement_id',
        'clarity_project_id',
        'meta_pixel_id',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
