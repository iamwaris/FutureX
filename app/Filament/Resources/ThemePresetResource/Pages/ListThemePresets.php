<?php

namespace App\Filament\Resources\ThemePresetResource\Pages;

use App\Filament\Resources\ThemePresetResource;
use App\Models\ThemePreset;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListThemePresets extends ListRecords
{
    protected static string $resource = ThemePresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('saveCurrent')
                ->label('Save Current Theme as Preset')
                ->icon('heroicon-o-camera')
                ->form([
                    TextInput::make('name')->required()->maxLength(255),
                ])
                ->action(function (array $data) {
                    ThemePreset::captureCurrent($data['name']);

                    Notification::make()
                        ->title('Current theme saved as a preset')
                        ->success()
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
