<?php

namespace App\Filament\HR\Resources\EmployeeAddressResource\Pages;

use App\Filament\HR\Resources\EmployeeAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeAddress extends EditRecord
{
    protected static string $resource = EmployeeAddressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
