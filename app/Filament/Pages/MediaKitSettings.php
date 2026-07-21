<?php

namespace App\Filament\Pages;

use App\Models\MediaKit;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class MediaKitSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Media Kit';

    protected static ?string $title = 'Media Kit';

    protected static string $view = 'filament.pages.media-kit-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(MediaKit::current()->toArray());
    }

    private function demographicRepeater(string $name, string $label): Repeater
    {
        return Repeater::make($name)
            ->label($label)
            ->schema([
                TextInput::make('label')->required(),
                TextInput::make('percentage')->numeric()->suffix('%')->required(),
            ])
            ->columns(2)
            ->defaultItems(0)
            ->addActionLabel("Add {$label} row");
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Overview')
                    ->schema([
                        Textarea::make('bio')
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('brand_values')
                            ->helperText('Comma-separated, e.g. Authenticity, Competitive Excellence, Community First')
                            ->columnSpanFull()
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? $state : array_filter(array_map('trim', explode(',', (string) $state))))
                            ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                    ]),
                Section::make('Audience Reach')
                    ->schema([
                        TextInput::make('avg_viewers')->numeric()->required(),
                        TextInput::make('peak_viewers')->numeric()->required(),
                        TextInput::make('monthly_impressions')->numeric()->required(),
                    ])
                    ->columns(3),
                Section::make('Demographics')
                    ->schema([
                        $this->demographicRepeater('age_ranges', 'Age Ranges'),
                        $this->demographicRepeater('gender_distribution', 'Gender Distribution'),
                        $this->demographicRepeater('languages', 'Languages'),
                        $this->demographicRepeater('geographic_breakdown', 'Geographic Breakdown'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        MediaKit::current()->update($this->form->getState());

        Notification::make()
            ->title('Media Kit updated')
            ->success()
            ->send();
    }
}
