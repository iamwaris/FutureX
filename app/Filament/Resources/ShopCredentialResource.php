<?php

namespace App\Filament\Resources;

use App\Models\ShopCredential;
use App\Filament\Resources\ShopCredentialResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ShopCredentialResource extends Resource
{
    protected static ?string $model = ShopCredential::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Integrations';

    protected static ?string $navigationLabel = 'Shop Providers';

    protected static ?string $modelLabel = 'shop provider';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('platform')
                    ->options([
                        'shopify' => 'Shopify',
                        'fourthwall' => 'Fourthwall',
                        'woocommerce' => 'WooCommerce',
                        'gumroad' => 'Gumroad',
                        'spring' => 'Spring',
                    ])
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->native(false),
                TextInput::make('store_url')
                    ->label('Store URL / Domain')
                    ->helperText('Shopify: yourstore.myshopify.com. WooCommerce: your site URL. Fourthwall/Gumroad/Spring: usually not needed.')
                    ->maxLength(255),
                TextInput::make('access_token')
                    ->label('Access Token / API Key')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state)),
                TextInput::make('api_secret')
                    ->label('API Secret')
                    ->helperText('WooCommerce: consumer secret. Others: usually not needed.')
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
                TextColumn::make('store_url')
                    ->limit(30),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                ToggleColumn::make('is_enabled')
                    ->label('Enabled'),
            ])
            ->actions([
                Tables\Actions\Action::make('activate')
                    ->label('Make Active')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (ShopCredential $record) => ! $record->is_active)
                    ->action(function (ShopCredential $record) {
                        $record->activate();

                        Notification::make()
                            ->title("{$record->platform} is now the active shop provider")
                            ->success()
                            ->send();
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
            'index' => Pages\ListShopCredentials::route('/'),
            'create' => Pages\CreateShopCredential::route('/create'),
            'edit' => Pages\EditShopCredential::route('/{record}/edit'),
        ];
    }
}
