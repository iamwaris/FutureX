<?php

namespace App\Filament\Resources\ShopCredentialResource\Pages;

use App\Filament\Resources\ShopCredentialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShopCredential extends EditRecord
{
    protected static string $resource = ShopCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
