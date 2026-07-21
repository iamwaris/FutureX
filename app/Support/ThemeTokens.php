<?php

namespace App\Support;

/**
 * The single list of theme token field names, shared between ThemeSetting
 * (the live/active theme) and ThemePreset (named, storable snapshots of
 * that same shape) — and by ModeManager, which copies values between them.
 */
class ThemeTokens
{
    public const FIELDS = [
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
}
