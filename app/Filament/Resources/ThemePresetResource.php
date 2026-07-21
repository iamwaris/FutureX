<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThemePresetResource\Pages;
use App\Models\ThemePreset;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThemePresetResource extends Resource
{
    protected static ?string $model = ThemePreset::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Theme Presets';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Tabs::make('Theme')
                    ->tabs([
                        Tab::make('Colors')
                            ->schema([
                                ColorPicker::make('primary_color')->label('Primary'),
                                ColorPicker::make('secondary_color')->label('Secondary'),
                                ColorPicker::make('background_color')->label('Background'),
                                ColorPicker::make('surface_color')->label('Surface'),
                                ColorPicker::make('card_color')->label('Card'),
                                ColorPicker::make('border_color')->label('Border'),
                                ColorPicker::make('success_color')->label('Success'),
                                ColorPicker::make('warning_color')->label('Warning'),
                                ColorPicker::make('error_color')->label('Error'),
                                ColorPicker::make('text_primary_color')->label('Text — Primary'),
                                ColorPicker::make('text_secondary_color')->label('Text — Secondary'),
                                ColorPicker::make('text_muted_color')->label('Text — Muted'),
                            ])
                            ->columns(3),
                        Tab::make('Typography & Appearance')
                            ->schema([
                                TextInput::make('font_heading')->required(),
                                TextInput::make('font_body')->required(),
                                TextInput::make('radius')->numeric()->required(),
                                Select::make('shadow_style')
                                    ->options(['none' => 'None', 'subtle' => 'Subtle', 'soft' => 'Soft'])
                                    ->native(false)
                                    ->required(),
                                Select::make('animation_intensity')
                                    ->options(['none' => 'None', 'subtle' => 'Subtle', 'normal' => 'Normal', 'expressive' => 'Expressive'])
                                    ->native(false)
                                    ->required(),
                                Select::make('section_spacing')
                                    ->options(['compact' => 'Compact', 'comfortable' => 'Comfortable', 'spacious' => 'Spacious'])
                                    ->native(false)
                                    ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold'),
                ColorColumn::make('primary_color'),
                ColorColumn::make('secondary_color'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('apply')
                    ->label('Apply')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (ThemePreset $record) {
                        $record->applyToLiveTheme();

                        Notification::make()
                            ->title("Applied \"{$record->name}\" to the live theme")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(fn (ThemePreset $record) => $record->replicate()->fill([
                        'name' => $record->name.' (Copy)',
                    ])->save()),
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
            'index' => Pages\ListThemePresets::route('/'),
            'create' => Pages\CreateThemePreset::route('/create'),
            'edit' => Pages\EditThemePreset::route('/{record}/edit'),
        ];
    }
}
