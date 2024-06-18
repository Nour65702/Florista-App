<?php

namespace App\Filament\HR\Resources\EmployeeResource\Pages;

use App\Filament\HR\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;
}
