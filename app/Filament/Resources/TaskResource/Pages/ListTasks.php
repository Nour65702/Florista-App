<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'completed' => Tab::make()->query(fn ($query) => $query->where('completed', '1')),
            'not Completed' => Tab::make()->query(fn ($query) => $query->where('completed', '0')),
            'Important' => Tab::make()->query(fn ($query) => $query->where('priority', 'high')),
        ];
    }
}
