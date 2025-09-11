<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\TimeSheet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersonalWidgetStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user())),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user())),
            Stat::make('Total Worked Hours', $this->getTotalWork(Auth::user())),
            Stat::make('Total Paused Hours', $this->getTotalPaused(Auth::user())),
        ];
    }
    protected function getPendingHolidays(User $user): int
    {
        $totalPendingHolidays = Holiday::where('user_id', $user->id)
            ->where('type', 'pending')
            ->get()
            ->count();

        return $totalPendingHolidays;
    }

    protected function getApprovedHolidays(User $user): int
    {
        $totalApprovedHolidays = Holiday::where('user_id', $user->id)
            ->where('type', 'approved')
            ->get()
            ->count();

        return $totalApprovedHolidays;
    }

    protected function getTotalWork(User $user)
    {
        $timeSheets = TimeSheet::where('user_id', $user->id)
            ->where('type', 'work')
            ->whereDate('created_at', Carbon::today())
            ->get();
        $sumSeconds = 0;
        foreach ($timeSheets as $timeSheet) {
            $start = \Carbon\Carbon::parse($timeSheet->day_in);
            $end = \Carbon\Carbon::parse($timeSheet->day_out);
            $diff = $start->diffInSeconds($end);
            $sumSeconds += $diff;
        }
        $tiempoFormato = gmdate("H:i:s", $sumSeconds);
        return $tiempoFormato;

    }

        protected function getTotalPaused(User $user)
    {
        $timeSheets = TimeSheet::where('user_id', $user->id)
            ->where('type', 'pause')
            ->whereDate('created_at', Carbon::today())
            ->get();
        $sumSeconds = 0;
        foreach ($timeSheets as $timeSheet) {
            $start = \Carbon\Carbon::parse($timeSheet->day_in);
            $end = \Carbon\Carbon::parse($timeSheet->day_out);
            $diff = $start->diffInSeconds($end);
            $sumSeconds += $diff;
        }
        $tiempoFormato = gmdate("H:i:s", $sumSeconds);
        return $tiempoFormato;

    }
    

}


    

   