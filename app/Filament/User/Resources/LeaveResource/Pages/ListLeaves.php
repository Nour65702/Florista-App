<?php

namespace App\Filament\User\Resources\LeaveResource\Pages;

use App\Filament\User\Resources\LeaveResource;
use App\Filament\User\Resources\LeaveResource\Widgets\UserLeavesWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeaves extends ListRecords
{
    protected static string $resource = LeaveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            UserLeavesWidget::class
        ];
    }
}
