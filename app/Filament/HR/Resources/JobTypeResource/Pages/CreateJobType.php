<?php

namespace App\Filament\HR\Resources\JobTypeResource\Pages;

use App\Filament\HR\Resources\JobTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobType extends CreateRecord
{
    protected static string $resource = JobTypeResource::class;
}
