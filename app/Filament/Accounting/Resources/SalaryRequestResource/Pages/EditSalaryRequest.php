<?php

namespace App\Filament\Accounting\Resources\SalaryRequestResource\Pages;

use App\Filament\Accounting\Resources\SalaryRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalaryRequest extends EditRecord
{
    protected static string $resource = SalaryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
