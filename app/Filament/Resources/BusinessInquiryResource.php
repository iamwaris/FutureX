<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessInquiryResource\Pages;
use App\Models\BusinessInquiry;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BusinessInquiryResource extends Resource
{
    protected static ?string $model = BusinessInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Business Inquiries';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Submission')
                    ->schema([
                        TextInput::make('name')->disabled(),
                        TextInput::make('company')->disabled(),
                        TextInput::make('email')->disabled(),
                        TextInput::make('campaign_type')->disabled(),
                        TextInput::make('budget')->disabled(),
                        TextInput::make('timeline')->disabled(),
                        Textarea::make('message')->disabled()->columnSpanFull()->rows(4),
                    ])
                    ->columns(2),
                Toggle::make('is_read')
                    ->label('Marked as read'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('is_read')
                    ->boolean()
                    ->label('Read'),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('semibold'),
                TextColumn::make('company')
                    ->searchable(),
                TextColumn::make('campaign_type')
                    ->badge(),
                TextColumn::make('budget'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Read status'),
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
            'index' => Pages\ListBusinessInquiries::route('/'),
            'edit' => Pages\EditBusinessInquiry::route('/{record}/edit'),
        ];
    }
}
