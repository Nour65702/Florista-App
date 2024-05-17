<?php

namespace App\Filament\Resources\ProviderLicenceResource\Pages;

use App\Filament\Resources\ProviderLicenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProviderLicence extends EditRecord
{
    protected static string $resource = ProviderLicenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
