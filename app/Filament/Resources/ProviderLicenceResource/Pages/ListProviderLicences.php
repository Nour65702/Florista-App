<?php

namespace App\Filament\Resources\ProviderLicenceResource\Pages;

use App\Filament\Resources\ProviderLicenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProviderLicences extends ListRecords
{
    protected static string $resource = ProviderLicenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
