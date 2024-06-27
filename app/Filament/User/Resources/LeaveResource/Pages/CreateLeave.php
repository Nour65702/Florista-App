<?php

namespace App\Filament\User\Resources\LeaveResource\Pages;

use App\Filament\User\Resources\LeaveResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLeave extends CreateRecord
{
    protected static string $resource = LeaveResource::class;
}
