<?php

namespace App\Services;

use App\Models\ThemeSetting;
use Illuminate\Support\Facades\Cache;

/**
 * Translates the editable ThemeSetting row into runtime CSS custom
 * properties. Nothing in the frontend should hardcode a color, font,
 * radius, shadow, or spacing value outside of what this class emits —
 * that's what makes the theme admin-editable without touching code.
 */
class ThemeService
{
    private const SHADOW_STYLES = [
        'none' => 'none',
        'subtle' => '0 1px 2px rgba(0, 0, 0, 0.06), 0 1px 1px rgba(0, 0, 0, 0.04)',
        'soft' => '0 4px 16px rgba(0, 0, 0, 0.10), 0 2px 6px rgba(0, 0, 0, 0.06)',
    ];

    private const SECTION_SPACING = [
        'compact' => '64px',
        'comfortable' => '96px',
        'spacious' => '128px',
    ];

    private const MOTION_SCALE = [
        'none' => '0',
        'subtle' => '0.6',
        'normal' => '1',
        'expressive' => '1.4',
    ];

    public function settings(): ThemeSetting
    {
        return ThemeSetting::current();
    }

    /**
     * Cached forever; the cache is flushed by ThemeSetting's saved/deleted
     * events, so this only recomputes right after an admin edit.
     */
    public function cssVariables(): string
    {
        return Cache::rememberForever(
            ThemeSetting::CACHE_KEY,
            fn () => $this->buildCssVariables($this->settings()),
        );
    }

    private function buildCssVariables(ThemeSetting $t): string
    {
        $vars = [
            '--color-primary' => $t->primary_color,
            '--color-secondary' => $t->secondary_color,
            '--color-background' => $t->background_color,
            '--color-surface' => $t->surface_color,
            '--color-card' => $t->card_color,
            '--color-border' => $t->border_color,
            '--color-success' => $t->success_color,
            '--color-warning' => $t->warning_color,
            '--color-error' => $t->error_color,
            '--color-text-primary' => $t->text_primary_color,
            '--color-text-secondary' => $t->text_secondary_color,
            '--color-text-muted' => $t->text_muted_color,

            '--font-heading' => "'{$t->font_heading}', ui-sans-serif, system-ui, sans-serif",
            '--font-body' => "'{$t->font_body}', ui-sans-serif, system-ui, sans-serif",

            '--radius-base' => "{$t->radius}px",
            '--shadow-elevation' => self::SHADOW_STYLES[$t->shadow_style] ?? self::SHADOW_STYLES['subtle'],

            '--motion-scale' => self::MOTION_SCALE[$t->animation_intensity] ?? self::MOTION_SCALE['normal'],
            '--section-spacing' => self::SECTION_SPACING[$t->section_spacing] ?? self::SECTION_SPACING['comfortable'],
        ];

        $declarations = collect($vars)
            ->map(fn (string $value, string $property) => "  {$property}: {$value};")
            ->implode("\n");

        return ":root {\n{$declarations}\n}\n";
    }

    /**
     * The Google Fonts <link> href for whichever heading/body fonts are
     * currently configured. Only requests each distinct family once.
     */
    public function googleFontsUrl(): string
    {
        $families = collect([$this->settings()->font_heading, $this->settings()->font_body])
            ->unique()
            ->map(fn (string $family) => 'family='.str_replace(' ', '+', $family).':wght@400;500;600;700;800')
            ->implode('&');

        return "https://fonts.googleapis.com/css2?{$families}&display=swap";
    }
}
