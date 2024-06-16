<?php

namespace App\Filament\Resources\ProviderResource\Pages;

use App\Filament\Resources\ProviderResource;
use App\Models\Provider;
use Illuminate\Support\Facades\File;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProvider extends CreateRecord
{
    protected static string $resource = ProviderResource::class;

   
}
