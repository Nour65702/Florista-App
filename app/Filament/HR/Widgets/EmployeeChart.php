<?php

namespace App\Filament\HR\Widgets;

use App\Models\Employee;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class EmployeeChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'employeeChart';

    protected static ?int $sort = 3;


    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Employee Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $employeeCountsByMonth = Employee::selectRaw('MONTH(date_of_joining) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Prepare data for all months
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $employeeCountsByMonth[$i] ?? 0;
        }
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Employees Joined',
                    'data' => $data,
                    'type' => 'column',
                ],
                [
                    'name' => 'Line',
                    'data' => $data,
                    'type' => 'line',
                ],
            ],
            'stroke' => [
                'width' => [0, 4],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'legend' => [
                'labels' => [
                    'fontFamily' => 'inherit',
                ],
            ],
        ];
    }
}
