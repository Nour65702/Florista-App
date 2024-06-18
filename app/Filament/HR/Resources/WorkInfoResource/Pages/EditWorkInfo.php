<?php

namespace App\Filament\HR\Resources\WorkInfoResource\Pages;

use App\Filament\HR\Resources\WorkInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkInfo extends EditRecord
{
    protected static string $resource = WorkInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
