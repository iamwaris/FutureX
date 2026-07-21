<?php

namespace Database\Seeders;

use App\Models\CreatorMode;
use App\Models\ThemePreset;
use Illuminate\Database\Seeder;

class CreatorModeSeeder extends Seeder
{
    /**
     * Shared chrome (background/surface/card/border/text/typography) across
     * all mode presets — only the brand accent colors change per mode, plus
     * whatever section_overrides make that mode's homepage layout distinct.
     */
    private const BASE_TOKENS = [
        'background_color' => '#0B0B0F',
        'surface_color' => '#131316',
        'card_color' => '#18181C',
        'border_color' => '#27272A',
        'success_color' => '#22C55E',
        'warning_color' => '#F59E0B',
        'error_color' => '#EF4444',
        'text_primary_color' => '#FAFAFA',
        'text_secondary_color' => '#A1A1AA',
        'text_muted_color' => '#71717A',
        'font_heading' => 'Inter',
        'font_body' => 'Inter',
        'radius' => 16,
        'shadow_style' => 'subtle',
        'animation_intensity' => 'normal',
        'section_spacing' => 'comfortable',
    ];

    public function run(): void
    {
        $sponsorPreset = ThemePreset::query()->updateOrCreate(
            ['name' => 'Sponsor Mode'],
            [...self::BASE_TOKENS, 'primary_color' => '#2563EB', 'secondary_color' => '#0EA5E9'],
        );

        $eventPreset = ThemePreset::query()->updateOrCreate(
            ['name' => 'Event Mode'],
            [...self::BASE_TOKENS, 'primary_color' => '#F59E0B', 'secondary_color' => '#EF4444'],
        );

        $charityPreset = ThemePreset::query()->updateOrCreate(
            ['name' => 'Charity Mode'],
            [...self::BASE_TOKENS, 'primary_color' => '#EF4444', 'secondary_color' => '#F43F5E'],
        );

        CreatorMode::query()->updateOrCreate(
            ['key' => 'sponsor'],
            [
                'label' => 'Sponsor Mode',
                'description' => 'Optimized for brands evaluating a partnership — surfaces stats and sponsors, hides the shop.',
                'theme_preset_id' => $sponsorPreset->id,
                'section_overrides' => [
                    ['key' => 'sponsors', 'label' => 'Sponsors', 'is_enabled' => true, 'order' => 1],
                    ['key' => 'snapshot', 'label' => 'Creator Snapshot', 'is_enabled' => true, 'order' => 2],
                    ['key' => 'shop', 'label' => 'Shop', 'is_enabled' => false, 'order' => 8],
                ],
            ],
        );

        CreatorMode::query()->updateOrCreate(
            ['key' => 'event'],
            [
                'label' => 'Event Mode',
                'description' => 'For tournaments and conventions — brings the schedule to the top of the homepage.',
                'theme_preset_id' => $eventPreset->id,
                'section_overrides' => [
                    ['key' => 'schedule', 'label' => 'Stream Schedule', 'is_enabled' => true, 'order' => 1],
                ],
            ],
        );

        CreatorMode::query()->updateOrCreate(
            ['key' => 'charity'],
            [
                'label' => 'Charity Mode',
                'description' => 'Promotes a donation campaign with a dedicated banner right under the hero.',
                'theme_preset_id' => $charityPreset->id,
                'section_overrides' => [
                    ['key' => 'charity-banner', 'label' => 'Charity Banner', 'is_enabled' => true, 'order' => 1],
                ],
            ],
        );
    }
}
