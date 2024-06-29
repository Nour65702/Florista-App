<?php

namespace App\Filament\Resources\TypeAdditionResource\Pages;

use App\Filament\Resources\TypeAdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeAdditions extends ListRecords
{
    protected static string $resource = TypeAdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
