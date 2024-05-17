<?php

namespace App\Filament\Widgets;

use App\Models\Provider;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProviderChart extends ChartWidget
{
    protected static ?string $heading = 'Employees Chart';

    protected static string $color = 'info';

    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $data = Trend::model(Provider::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Employees Joined',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
