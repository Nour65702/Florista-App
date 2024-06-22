<?php

namespace App\Filament\Resources\AdditionResource\Pages;

use App\Filament\Resources\AdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddition extends EditRecord
{
    protected static string $resource = AdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
