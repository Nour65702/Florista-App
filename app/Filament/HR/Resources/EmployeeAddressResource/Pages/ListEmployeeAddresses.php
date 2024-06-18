<?php

namespace App\Filament\HR\Resources\EmployeeAddressResource\Pages;

use App\Filament\HR\Resources\EmployeeAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeAddresses extends ListRecords
{
    protected static string $resource = EmployeeAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
