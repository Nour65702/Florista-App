<?php

namespace App\Filament\Resources\UserCustomBouquetsResource\Pages;

use App\Filament\Resources\UserCustomBouquetsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserCustomBouquets extends ListRecords
{
    protected static string $resource = UserCustomBouquetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
