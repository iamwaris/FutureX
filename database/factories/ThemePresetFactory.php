<?php

namespace Database\Factories;

use App\Models\ThemePreset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ThemePreset>
 */
class ThemePresetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'primary_color' => $this->faker->hexColor(),
            'secondary_color' => $this->faker->hexColor(),
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
    }
}
