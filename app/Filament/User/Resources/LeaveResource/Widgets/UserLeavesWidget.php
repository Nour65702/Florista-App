<?php

namespace App\Filament\User\Resources\LeaveResource\Widgets;

use App\Models\Leave;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserLeavesWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = Auth::id();
        $leaves = Leave::where('employee_id', $userId)->get();
        
        $totalLeaves = $leaves->count();
        $approvedLeaves = $leaves->where('status', 'approved')->count();
        $pendingLeaves = $leaves->where('status', 'pending')->count();
        $rejectedLeaves = $leaves->where('status', 'rejected')->count();

        return [
            Stat::make('Total Leaves', $totalLeaves)
                ->description('Total number of leaves')
                ->icon('heroicon-s-calendar'),
            
            Stat::make('Approved Leaves', $approvedLeaves)
                ->description('Approved leaves')
                ->icon('heroicon-s-check-circle')
                ->color('success'),
            
            Stat::make('Pending Leaves', $pendingLeaves)
                ->description('Pending leaves')
                ->icon('heroicon-s-clock')
                ->color('warning'),

            Stat::make('Rejected Leaves', $rejectedLeaves)
                ->description('Rejected leaves')
                ->icon('heroicon-s-x-circle')
                ->color('danger'),
        ];
    }
}
