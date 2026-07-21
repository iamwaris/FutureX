<?php

namespace App\Filament\Resources\BusinessInquiryResource\Pages;

use App\Filament\Resources\BusinessInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBusinessInquiry extends EditRecord
{
    protected static string $resource = BusinessInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
