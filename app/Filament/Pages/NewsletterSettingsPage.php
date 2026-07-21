<?php

namespace App\Filament\Pages;

use App\Models\NewsletterSetting;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class NewsletterSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Integrations';

    protected static ?string $navigationLabel = 'Newsletter';

    protected static ?string $title = 'Newsletter';

    protected static string $view = 'filament.pages.newsletter-settings-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(NewsletterSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('provider')
                    ->options([
                        'none' => 'Not configured',
                        'beehiiv' => 'Beehiiv',
                        'mailchimp' => 'Mailchimp',
                    ])
                    ->required()
                    ->native(false)
                    ->live(),
                Toggle::make('is_enabled')
                    ->label('Enabled'),
                TextInput::make('api_key')
                    ->label('API Key')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->visible(fn ($get) => $get('provider') !== 'none'),
                TextInput::make('list_id')
                    ->label('Publication / List ID')
                    ->helperText('Beehiiv: publication ID. Mailchimp: audience/list ID.')
                    ->visible(fn ($get) => $get('provider') !== 'none'),
            ])
            ->columns(2);
    }

    public function save(): void
    {
        NewsletterSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Newsletter settings updated')
            ->success()
            ->send();
    }
}
