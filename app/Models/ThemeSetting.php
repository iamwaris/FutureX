<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ThemeSetting extends Model
{
    public const CACHE_KEY = 'theme:css-vars';

    protected $fillable = [
        'primary_color',
        'secondary_color',
        'background_color',
        'surface_color',
        'card_color',
        'border_color',
        'success_color',
        'warning_color',
        'error_color',
        'text_primary_color',
        'text_secondary_color',
        'text_muted_color',
        'font_heading',
        'font_body',
        'radius',
        'shadow_style',
        'animation_intensity',
        'section_spacing',
    ];

    protected function casts(): array
    {
        return [
            'radius' => 'integer',
        ];
    }

    /**
     * CreatorOS ships a single active theme (no multi-tenant sites), so the
     * whole app reads/writes through this one row rather than a real table scan.
     */
    public static function current(): self
    {
        $instance = static::query()->firstOrCreate(['id' => 1]);

        // firstOrCreate's create() path only inserts the given attributes and
        // relies on the DB to apply column defaults (font_heading, radius,
        // etc.) — it never re-fetches, so those columns are null in memory
        // until refreshed. Without this, the very first request ever served
        // against a fresh database would crash wherever those defaults are
        // used (e.g. ThemeService::googleFontsUrl()).
        if ($instance->wasRecentlyCreated) {
            $instance->refresh();
        }

        return $instance;
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }
}
