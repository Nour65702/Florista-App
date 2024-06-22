<?php

namespace App\Filament\Resources\AdditionProductResource\Pages;

use App\Filament\Resources\AdditionProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdditionProduct extends EditRecord
{
    protected static string $resource = AdditionProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
