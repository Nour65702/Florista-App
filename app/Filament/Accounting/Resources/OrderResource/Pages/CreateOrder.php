<?php

namespace App\Filament\Accounting\Resources\OrderResource\Pages;

use App\Filament\Accounting\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
