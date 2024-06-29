<?php

namespace App\Filament\Resources\TypeAdditionResource\Pages;

use App\Filament\Resources\TypeAdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeAddition extends EditRecord
{
    protected static string $resource = TypeAdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
