<?php

namespace Tests\Feature;

use App\Models\CreatorMode;
use App\Models\PageSection;
use App\Models\ThemePreset;
use App\Models\ThemeSetting;
use App\Services\Modes\ModeManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModeManagerTest extends TestCase
{
    use RefreshDatabase;

    private function seedDefaultSections(): void
    {
        $this->seed(\Database\Seeders\PageSectionSeeder::class);
    }

    public function test_activating_a_mode_applies_its_theme_preset_and_section_overrides(): void
    {
        $this->seedDefaultSections();

        ThemeSetting::current()->update(['primary_color' => '#6366F1']);

        $preset = ThemePreset::factory()->create(['primary_color' => '#F59E0B']);
        $mode = CreatorMode::create([
            'key' => 'event',
            'label' => 'Event Mode',
            'theme_preset_id' => $preset->id,
            'section_overrides' => [
                ['key' => 'schedule', 'label' => 'Stream Schedule', 'is_enabled' => true, 'order' => 1],
            ],
        ]);

        app(ModeManager::class)->activate($mode);

        $this->assertSame('#F59E0B', ThemeSetting::current()->primary_color);
        $this->assertSame(1, PageSection::query()->where('key', 'schedule')->value('order'));
        $this->assertSame('event', app(ModeManager::class)->currentModeKey());
    }

    /**
     * The core M9 exit criteria: toggling Event Mode changes the homepage's
     * visual theme and section priority live, and toggling back restores
     * the previous state exactly.
     */
    public function test_deactivating_restores_the_exact_previous_theme_and_section_state(): void
    {
        $this->seedDefaultSections();

        ThemeSetting::current()->update([
            'primary_color' => '#6366F1',
            'secondary_color' => '#22D3EE',
            'radius' => 16,
        ]);
        $originalScheduleOrder = PageSection::query()->where('key', 'schedule')->value('order');

        $preset = ThemePreset::factory()->create(['primary_color' => '#F59E0B', 'radius' => 4]);
        $mode = CreatorMode::create([
            'key' => 'event',
            'label' => 'Event Mode',
            'theme_preset_id' => $preset->id,
            'section_overrides' => [
                ['key' => 'schedule', 'label' => 'Stream Schedule', 'is_enabled' => true, 'order' => 1],
            ],
        ]);

        $manager = app(ModeManager::class);
        $manager->activate($mode);

        // Sanity check the mode actually changed something before restoring.
        $this->assertSame('#F59E0B', ThemeSetting::current()->primary_color);

        $manager->deactivate();

        $theme = ThemeSetting::current();
        $this->assertSame('#6366F1', $theme->primary_color);
        $this->assertSame('#22D3EE', $theme->secondary_color);
        $this->assertSame(16, $theme->radius);
        $this->assertSame($originalScheduleOrder, PageSection::query()->where('key', 'schedule')->value('order'));
        $this->assertNull($manager->currentModeKey());
    }

    public function test_charity_mode_banner_section_is_removed_on_deactivate(): void
    {
        $this->seedDefaultSections();

        $preset = ThemePreset::factory()->create();
        $mode = CreatorMode::create([
            'key' => 'charity',
            'label' => 'Charity Mode',
            'theme_preset_id' => $preset->id,
            'section_overrides' => [
                ['key' => 'charity-banner', 'label' => 'Charity Banner', 'is_enabled' => true, 'order' => 1],
            ],
        ]);

        $manager = app(ModeManager::class);
        $manager->activate($mode);

        $this->assertDatabaseHas('page_sections', ['key' => 'charity-banner']);

        $manager->deactivate();

        // The banner didn't exist before Charity Mode was turned on, so
        // restoring "exactly" means it's gone, not just disabled.
        $this->assertDatabaseMissing('page_sections', ['key' => 'charity-banner']);
    }

    public function test_switching_directly_between_two_modes_still_restores_true_defaults_on_final_deactivate(): void
    {
        $this->seedDefaultSections();
        ThemeSetting::current()->update(['primary_color' => '#6366F1']);

        $sponsorPreset = ThemePreset::factory()->create(['primary_color' => '#2563EB']);
        $eventPreset = ThemePreset::factory()->create(['primary_color' => '#F59E0B']);

        $sponsorMode = CreatorMode::create([
            'key' => 'sponsor', 'label' => 'Sponsor Mode', 'theme_preset_id' => $sponsorPreset->id,
        ]);
        $eventMode = CreatorMode::create([
            'key' => 'event', 'label' => 'Event Mode', 'theme_preset_id' => $eventPreset->id,
        ]);

        $manager = app(ModeManager::class);

        $manager->activate($sponsorMode);
        $this->assertSame('#2563EB', ThemeSetting::current()->primary_color);

        // Switching directly to Event Mode without an explicit deactivate.
        $manager->activate($eventMode);
        $this->assertSame('#F59E0B', ThemeSetting::current()->primary_color);
        $this->assertSame('event', $manager->currentModeKey());

        $manager->deactivate();

        // Must be the TRUE original, not "Sponsor Mode" (which would happen
        // if activating Event Mode snapshotted Sponsor Mode's state instead
        // of restoring to default first).
        $this->assertSame('#6366F1', ThemeSetting::current()->primary_color);
    }

    public function test_deactivating_with_no_active_mode_is_a_safe_no_op(): void
    {
        $this->seedDefaultSections();
        ThemeSetting::current()->update(['primary_color' => '#6366F1']);

        app(ModeManager::class)->deactivate();

        $this->assertSame('#6366F1', ThemeSetting::current()->primary_color);
    }
}
