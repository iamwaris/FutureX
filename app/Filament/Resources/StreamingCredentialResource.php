<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StreamingCredentialResource\Pages;
use App\Models\StreamingCredential;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class StreamingCredentialResource extends Resource
{
    protected static ?string $model = StreamingCredential::class;

    protected static ?string $navigationIcon = 'heroicon-o-signal';

    protected static ?string $navigationGroup = 'Integrations';

    protected static ?string $navigationLabel = 'Streaming Platforms';

    protected static ?string $modelLabel = 'streaming platform';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('platform')
                    ->options([
                        'twitch' => 'Twitch',
                        'kick' => 'Kick',
                        'youtube' => 'YouTube',
                    ])
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->native(false),
                TextInput::make('channel_id')
                    ->label('Channel / Broadcaster ID')
                    ->helperText('Twitch: broadcaster user ID. Kick: channel slug. YouTube: channel ID.')
                    ->required(),
                TextInput::make('client_id')
                    ->label('Client ID / API Key')
                    ->required(),
                TextInput::make('client_secret')
                    ->label('Client Secret')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state)),
                Toggle::make('is_enabled')
                    ->label('Enabled')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('platform')
                    ->badge(),
                TextColumn::make('channel_id'),
                ToggleColumn::make('is_enabled')
                    ->label('Enabled'),
                TextColumn::make('cached_access_token_expires_at')
                    ->label('Token expires')
                    ->dateTime()
                    ->placeholder('—'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStreamingCredentials::route('/'),
        ];
    }
}
