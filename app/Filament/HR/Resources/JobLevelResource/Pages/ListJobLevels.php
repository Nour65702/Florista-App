<?php

namespace App\Filament\HR\Resources\JobLevelResource\Pages;

use App\Filament\HR\Resources\JobLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobLevels extends ListRecords
{
    protected static string $resource = JobLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
