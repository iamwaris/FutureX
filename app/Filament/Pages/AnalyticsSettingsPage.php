<?php

namespace App\Filament\Pages;

use App\Models\AnalyticsSetting;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AnalyticsSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationGroup = 'Integrations';

    protected static ?string $navigationLabel = 'Analytics & Tracking';

    protected static ?string $title = 'Analytics & Tracking';

    protected static string $view = 'filament.pages.analytics-settings-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AnalyticsSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ga4_measurement_id')
                    ->label('Google Analytics Measurement ID')
                    ->helperText('e.g. G-XXXXXXXXXX. Leave blank to disable — the script only loads when this is set.'),
                TextInput::make('clarity_project_id')
                    ->label('Microsoft Clarity Project ID')
                    ->helperText('Leave blank to disable.'),
                TextInput::make('meta_pixel_id')
                    ->label('Meta Pixel ID')
                    ->helperText('Leave blank to disable.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        AnalyticsSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Analytics settings updated')
            ->success()
            ->send();
    }
}
