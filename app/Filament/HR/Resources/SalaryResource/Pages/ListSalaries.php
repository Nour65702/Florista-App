<?php

namespace App\Filament\HR\Resources\SalaryResource\Pages;

use App\Filament\HR\Resources\SalaryResource;
use App\Filament\HR\Resources\SalaryResource\Widgets\UserSalaryWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
   
}
