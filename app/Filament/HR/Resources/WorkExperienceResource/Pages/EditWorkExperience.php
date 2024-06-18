<?php

namespace App\Filament\HR\Resources\WorkExperienceResource\Pages;

use App\Filament\HR\Resources\WorkExperienceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkExperience extends EditRecord
{
    protected static string $resource = WorkExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
