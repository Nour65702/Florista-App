<?php

namespace App\Filament\User\Resources\AttendanceResource\Pages;

use App\Filament\User\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
