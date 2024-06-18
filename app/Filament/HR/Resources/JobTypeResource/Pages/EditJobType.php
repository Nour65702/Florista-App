<?php

namespace App\Filament\HR\Resources\JobTypeResource\Pages;

use App\Filament\HR\Resources\JobTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobType extends EditRecord
{
    protected static string $resource = JobTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
