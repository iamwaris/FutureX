<?php

namespace App\Filament\Resources\StreamingCredentialResource\Pages;

use App\Filament\Resources\StreamingCredentialResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageStreamingCredentials extends ManageRecords
{
    protected static string $resource = StreamingCredentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
