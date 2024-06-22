<?php

namespace App\Filament\Resources\AdditionProductResource\Pages;

use App\Filament\Resources\AdditionProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdditionProducts extends ListRecords
{
    protected static string $resource = AdditionProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
