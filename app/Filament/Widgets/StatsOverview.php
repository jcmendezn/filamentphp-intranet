<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
//use Illuminate\Container\Attributes\Auth;
use App\Filament\Support\AuthorizesWidgetWithShield;


class StatsOverview extends StatsOverviewWidget
{

    use AuthorizesWidgetWithShield;

    protected function getStats(): array
    {
        $totalEmployees = \App\Models\User::count();
        $totalHolidays = \App\Models\Holiday::count();
        $totalTimesheets = \App\Models\Timesheet::count();
        return [
            Stat::make('Total Employees admin', $totalEmployees)
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Holidays', $totalHolidays)
                ->description('7% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),  
            Stat::make('Total Timesheets', $totalTimesheets)
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
        ];
    }
}
