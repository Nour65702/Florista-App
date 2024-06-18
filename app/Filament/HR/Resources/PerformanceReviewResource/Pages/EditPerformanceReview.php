<?php

namespace App\Filament\HR\Resources\PerformanceReviewResource\Pages;

use App\Filament\HR\Resources\PerformanceReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerformanceReview extends EditRecord
{
    protected static string $resource = PerformanceReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
