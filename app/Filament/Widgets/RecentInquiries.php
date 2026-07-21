<?php

namespace App\Filament\Widgets;

use App\Models\BusinessInquiry;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentInquiries extends BaseWidget
{
    protected static ?string $heading = 'Recent Business Inquiries';

    public function table(Table $table): Table
    {
        return $table
            ->query(BusinessInquiry::query()->latest())
            ->defaultPaginationPageOption(5)
            ->columns([
                IconColumn::make('is_read')
                    ->boolean()
                    ->label('Read'),
                TextColumn::make('name')
                    ->weight('semibold'),
                TextColumn::make('campaign_type')
                    ->badge(),
                TextColumn::make('budget'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (BusinessInquiry $record) => route('filament.admin.resources.business-inquiries.edit', $record))
                    ->icon('heroicon-o-arrow-top-right-on-square'),
            ]);
    }
}
