<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Number;

class SummaryDent extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $is_show = $this->filters['is_show'];
        $startDate = $this->filters['startDate'];
        $endDate = $this->filters['endDate'];
        $incomeCurrent = 0;
        $appcount = 0;
        $incomeChangePercentage = 0;
        $incomeStatus = true;
        $appcountChangePercentage = 0;
        $appcountStatus = true;
        $pendingappcount = 0;
        if ($is_show == 1) {
            $incomeCurrent = Appointment::query()
                ->where('dentist_id', auth()->user()->id)
                ->whereDate('appointment_date', '>=', $startDate)
                ->whereDate('appointment_date', '<=', $endDate)
                ->sum('total_fee');
            $appcount = Appointment::query()
                ->where('dentist_id', auth()->user()->id)
                ->whereDate('appointment_date', '>=', $startDate)
                ->whereDate('appointment_date', '<=', $endDate)
                ->count();
            $pendingappcount = Appointment::query()
                ->where('dentist_id', auth()->user()->id)
                ->whereDate('appointment_date', '>=', $startDate)
                ->whereDate('appointment_date', '<=', $endDate)
                ->where('status', 'pending')
                ->count();

            $previousStartDate = Carbon::parse($startDate)->subMonth()->startOfMonth();
            $previousEndDate = Carbon::parse($startDate)->subMonth()->endOfMonth();

            // Calculate income for the previous period
            $incomePrevious = Appointment::query()
                ->where('dentist_id', auth()->user()->id)
                ->whereDate('appointment_date', '>=', $previousStartDate)
                ->whereDate('appointment_date', '<=', $previousEndDate)
                ->sum('total_fee');
            $appcountPrevious = Appointment::query()
                ->where('dentist_id', auth()->user()->id)
                ->whereDate('appointment_date', '>=', $previousStartDate)
                ->whereDate('appointment_date', '<=', $previousEndDate)
                ->count();
            // Calculate income Comparison in percentage
            if ($incomePrevious != 0 && $incomeCurrent != 0) {
                if ($incomeCurrent > $incomePrevious) {
                    $incomeChangePercentage = (($incomeCurrent - $incomePrevious) / $incomeCurrent) * 100;
                    $incomeStatus = true;
                } else {
                    $incomeChangePercentage = (($incomePrevious - $incomeCurrent) / $incomePrevious) * 100;
                    $incomeStatus = false;
                }
            } else {
                $incomeChangePercentage = ($incomeCurrent > 0) ? 100 : 0;
            }
            // Calculate appcount Comparison in percentage
            if ($appcountPrevious != 0 && $appcount != 0) {
                if ($appcount > $appcountPrevious) {
                    $appcountChangePercentage = (($appcount - $appcountPrevious) / $appcount) * 100;
                    $appcountStatus = true;
                } else {
                    $appcountChangePercentage = (($appcountPrevious - $appcount) / $appcountPrevious) * 100;
                    $appcountStatus = false;
                }
            } else {
                $appcountChangePercentage = ($appcount > 0) ? 100 : 0;
            }
        }
        $data_I = Trend::query(Appointment::where('dentist_id', auth()->user()->id))
            ->between(
                //get data from last year
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->sum('total_fee');
        $data_Count = Trend::query(Appointment::where('dentist_id', auth()->user()->id))
            ->between(
                //get data from last year
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->count();
        return [
            Stat::make('Total Income', $incomeCurrent)
                ->chart($is_show ? $data_I->map(fn (TrendValue $value) => $value->aggregate)->toArray() : [])
                ->description(($incomeStatus ? 'Increase ' : 'Decrease ') . Number::format($incomeChangePercentage, 2) . ' % compared to last month')
                ->descriptionIcon($incomeStatus ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color(($incomeStatus == true) ? 'success' : 'danger'),
            Stat::make('Total Appointments', $appcount)
                ->chart($is_show ? $data_Count->map(fn (TrendValue $value) => $value->aggregate)->toArray() : [])
                ->description(($appcountStatus ? 'Increase ' : 'Decrease ') . Number::format($appcountChangePercentage, 2) . ' % compared to last month')
                ->descriptionIcon($appcountStatus ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color(($appcountStatus == true) ? 'success' : 'danger'),
            Stat::make('Pending Appointments', $pendingappcount),
        ];
    }
}
