<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageSectionResource\Pages;
use App\Models\PageSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PageSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Page Builder';

    protected static ?string $modelLabel = 'section';

    /**
     * Must match a partial in resources/views/sections/*.blade.php — the
     * homepage renders sections via @includeIf('sections.' . $section->key),
     * so an unknown key just silently renders nothing rather than erroring.
     * Kept as a dropdown (not free text) so that can't happen by typo.
     */
    private const SECTION_KEYS = [
        'hero' => 'Hero',
        'live-status' => 'Live Status',
        'snapshot' => 'Creator Snapshot',
        'featured-content' => 'Featured Content',
        'about' => 'About',
        'schedule' => 'Stream Schedule',
        'community' => 'Community Hub',
        'sponsors' => 'Sponsors',
        'shop' => 'Shop',
        'newsletter' => 'Newsletter',
        'charity-banner' => 'Charity Banner',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('key')
                    ->label('Section Type')
                    ->options(self::SECTION_KEYS)
                    ->required()
                    ->native(false),
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_enabled')
                    ->label('Enabled')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order')
            ->reorderable('order')
            ->columns([
                TextColumn::make('label')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('key')
                    ->badge()
                    ->color('gray'),
                ToggleColumn::make('is_enabled')
                    ->label('Enabled'),
            ])
            ->actions([
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (PageSection $record) {
                        $record->replicate()->fill([
                            'label' => $record->label.' (Copy)',
                            'order' => PageSection::max('order') + 1,
                        ])->save();
                    }),
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
            'index' => Pages\ManagePageSections::route('/'),
        ];
    }
}
