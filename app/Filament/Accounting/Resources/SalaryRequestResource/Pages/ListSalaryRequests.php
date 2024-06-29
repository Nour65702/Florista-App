<?php

namespace App\Filament\Accounting\Resources\SalaryRequestResource\Pages;

use App\Filament\Accounting\Resources\SalaryRequestResource;
use App\Filament\HR\Resources\SalaryResource\Widgets\UserSalaryWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalaryRequests extends ListRecords
{
    protected static string $resource = SalaryRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
         //   Actions\CreateAction::make(),
        ];
    }
  
}
