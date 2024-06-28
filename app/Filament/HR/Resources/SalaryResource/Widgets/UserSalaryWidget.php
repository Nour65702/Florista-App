<?php

namespace App\Filament\HR\Resources\SalaryResource\Widgets;

use App\Models\SalaryRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserSalaryWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        $salaryRequests = SalaryRequest::whereHas('salary.employee', function ($query) use ($userId) {
            $query->where('id', $userId);
        })->get();

        $totalSalaries = $salaryRequests->sum('salary.amount');
        $pendingSalaries = $salaryRequests->where('status', 'pending')->count();
        $approvedSalaries = $salaryRequests->where('status', 'paid')->count();

        return [
            Stat::make('Total Salaries', $totalSalaries)
                ->description('Total amount of salaries')
                ->icon('heroicon-s-currency-dollar')
                ->color('primary'),

            Stat::make('Pending Salaries', $pendingSalaries)
                ->description('Total of pending salaries')
                ->icon('heroicon-s-clock')
                ->color('warning'),

            Stat::make('Approved Salaries', $approvedSalaries)
                ->description('Total of approved salaries')
                ->icon('heroicon-s-check-circle')
                ->color('success'),
        ];
    }
}
