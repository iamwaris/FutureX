<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityLinkResource\Pages;
use App\Models\CommunityLink;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CommunityLinkResource extends Resource
{
    protected static ?string $model = CommunityLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Community Hub';

    protected static ?string $modelLabel = 'community link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('platform')
                    ->options([
                        'discord' => 'Discord',
                        'reddit' => 'Reddit',
                        'x' => 'X',
                        'instagram' => 'Instagram',
                        'tiktok' => 'TikTok',
                        'youtube' => 'YouTube',
                        'twitch' => 'Twitch',
                        'kick' => 'Kick',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                TextInput::make('stat_label')
                    ->label('Stat')
                    ->helperText('e.g. "15,200 members"')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->url()
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_primary')
                    ->label('Spotlight card')
                    ->helperText('Only one should be enabled at a time — it gets the large featured treatment.'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->reorderable('order')
            ->columns([
                TextColumn::make('platform')
                    ->badge(),
                TextColumn::make('label'),
                TextColumn::make('stat_label')
                    ->label('Stat'),
                ToggleColumn::make('is_primary')
                    ->label('Spotlight'),
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
            'index' => Pages\ManageCommunityLinks::route('/'),
        ];
    }
}
