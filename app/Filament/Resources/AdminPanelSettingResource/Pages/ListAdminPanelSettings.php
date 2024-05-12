<?php

namespace App\Filament\Resources\AdminPanelSettingResource\Pages;

use App\Filament\Resources\AdminPanelSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminPanelSettings extends ListRecords
{
    protected static string $resource = AdminPanelSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
