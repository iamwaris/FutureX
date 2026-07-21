<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('platform')
                    ->options([
                        'youtube' => 'YouTube',
                        'twitch' => 'Twitch',
                        'tiktok' => 'TikTok',
                        'instagram' => 'Instagram',
                    ])
                    ->required()
                    ->native(false),
                Select::make('type')
                    ->options([
                        'video' => 'Video',
                        'clip' => 'Clip',
                        'short' => 'Short',
                        'vod' => 'VOD',
                    ])
                    ->required()
                    ->native(false),
                TextInput::make('url')
                    ->label('Video URL')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('category')
                    ->maxLength(255),
                TagsInput::make('tags')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at'),
                Toggle::make('is_pinned')
                    ->label('Pinned'),
                SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->collection('thumbnail')
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('thumbnail')
                    ->label(''),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('platform')
                    ->badge(),
                TextColumn::make('type')
                    ->badge()
                    ->color('gray'),
                IconColumn::make('is_pinned')
                    ->boolean()
                    ->label('Pinned'),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('platform')
                    ->options([
                        'youtube' => 'YouTube',
                        'twitch' => 'Twitch',
                        'tiktok' => 'TikTok',
                        'instagram' => 'Instagram',
                    ]),
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
