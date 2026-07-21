<?php

namespace App\Filament\Pages;

use App\Models\CreatorMode;
use App\Services\Modes\ModeManager;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ModeSwitcher extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Creator Modes';

    protected static ?string $title = 'Creator Modes';

    protected static string $view = 'filament.pages.mode-switcher';

    public function activate(int $modeId): void
    {
        $mode = CreatorMode::findOrFail($modeId);

        app(ModeManager::class)->activate($mode);

        Notification::make()
            ->title("{$mode->label} activated")
            ->success()
            ->send();
    }

    public function deactivate(): void
    {
        app(ModeManager::class)->deactivate();

        Notification::make()
            ->title('Restored to default')
            ->success()
            ->send();
    }

    protected function getViewData(): array
    {
        return [
            'modes' => CreatorMode::all(),
            'activeModeKey' => app(ModeManager::class)->currentModeKey(),
        ];
    }
}
