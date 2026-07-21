<?php

namespace App\Filament\Pages;

use App\Models\SnapshotStat;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SnapshotStatsSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Snapshot Stats';

    protected static ?string $title = 'Creator Snapshot';

    protected static string $view = 'filament.pages.snapshot-stats-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SnapshotStat::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Numbers')
                    ->description('Shown as animated counters on the homepage Snapshot section.')
                    ->schema([
                        TextInput::make('followers')->numeric()->required(),
                        TextInput::make('subscribers')->numeric()->required(),
                        TextInput::make('total_views')->numeric()->required(),
                        TextInput::make('years_creating')->numeric()->required(),
                        TextInput::make('videos_published')->numeric()->required(),
                        TextInput::make('community_members')->numeric()->required(),
                    ])
                    ->columns(3),
                Section::make('Auto-Sync')
                    ->description('Overwrites the field above from the matching platform\'s API on every scheduled sync, instead of relying on manual entry. Requires credentials configured under Integrations → Streaming Platforms.')
                    ->schema([
                        Toggle::make('sync_followers_from_twitch')
                            ->label('Sync Followers from Twitch'),
                        Toggle::make('sync_subscribers_from_youtube')
                            ->label('Sync Subscribers from YouTube'),
                        Toggle::make('sync_total_views_from_youtube')
                            ->label('Sync Total Views from YouTube'),
                        Toggle::make('sync_videos_from_youtube')
                            ->label('Sync Videos Published from YouTube'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        SnapshotStat::current()->update($this->form->getState());

        Notification::make()
            ->title('Snapshot stats updated')
            ->success()
            ->send();
    }
}
