<?php

namespace App\Services\Modes;

use App\Models\CreatorMode;
use App\Models\ModeSnapshot;
use App\Models\PageSection;
use App\Models\ThemeSetting;
use App\Support\ThemeTokens;

class ModeManager
{
    /**
     * Switching straight from one mode to another restores true defaults
     * first, then activates the new mode fresh — so snapshots never stack
     * (activating Event Mode while Charity Mode is live can't accidentally
     * snapshot "Charity Mode" as if it were the original default state).
     */
    public function activate(CreatorMode $mode): void
    {
        if ($this->currentModeKey() !== null) {
            $this->deactivate();
        }

        $this->captureSnapshot();

        if ($mode->themePreset) {
            $mode->themePreset->applyToLiveTheme();
        }

        foreach ($mode->section_overrides ?? [] as $override) {
            PageSection::query()->updateOrCreate(
                ['key' => $override['key']],
                [
                    'label' => $override['label'] ?? $override['key'],
                    'is_enabled' => $override['is_enabled'] ?? true,
                    'order' => $override['order'] ?? 0,
                ],
            );
        }

        ModeSnapshot::current()->update(['active_mode' => $mode->key]);
    }

    /**
     * Restores theme tokens and page_sections to exactly how they were the
     * moment before the currently-active mode was activated, then clears
     * the snapshot so the next activate() captures fresh state.
     */
    public function deactivate(): void
    {
        $snapshot = ModeSnapshot::current();

        if (! $snapshot->theme_snapshot) {
            return;
        }

        ThemeSetting::current()->update(
            collect($snapshot->theme_snapshot)->only(ThemeTokens::FIELDS)->all()
        );

        $originalSections = collect($snapshot->sections_snapshot);

        foreach ($originalSections as $section) {
            PageSection::query()->where('key', $section['key'])->update([
                'is_enabled' => $section['is_enabled'],
                'order' => $section['order'],
            ]);
        }

        // Anything the mode added (e.g. Charity Mode's charity-banner)
        // didn't exist before activation, so it shouldn't survive restore.
        PageSection::query()->whereNotIn('key', $originalSections->pluck('key'))->delete();

        $snapshot->update([
            'active_mode' => null,
            'theme_snapshot' => null,
            'sections_snapshot' => null,
        ]);
    }

    public function currentModeKey(): ?string
    {
        return ModeSnapshot::current()->active_mode;
    }

    private function captureSnapshot(): void
    {
        ModeSnapshot::current()->update([
            'theme_snapshot' => ThemeSetting::current()->only(ThemeTokens::FIELDS),
            'sections_snapshot' => PageSection::query()
                ->get(['key', 'is_enabled', 'order'])
                ->map(fn (PageSection $section) => $section->only(['key', 'is_enabled', 'order']))
                ->all(),
        ]);
    }
}
