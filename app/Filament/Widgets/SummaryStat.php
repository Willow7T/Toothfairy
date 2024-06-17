<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Purchaselog;
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

class SummaryStat extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        $startDate = $this->filters['startDate'];
        $endDate = $this->filters['endDate'];
        $is_show = $this->filters['is_show'];
        $incomeCurrent = 0;
        $expenseCurrent = 0;
        $incomeChangePercentage = 0;
        $incomeStatus = true;
        $expenseChangePercentage = 0;
        $expenseStatus = true;
        $profitCurrent = 0;
        $profitChangePercentage = 0;
        $profitStatus = true;
        if ($is_show == 1) {
            $incomeCurrent = Appointment::query()
                ->whereDate('appointment_date', '>=', $startDate)
                ->whereDate('appointment_date', '<=', $endDate)
                ->sum('total_fee');
            $expenseCurrent = Purchaselog::query()
                ->whereDate('purchase_date', '>=', $startDate)
                ->whereDate('purchase_date', '<=', $endDate)
                ->sum('total_expense');
            $profitCurrent = $incomeCurrent - $expenseCurrent;

            $previousStartDate = Carbon::parse($startDate)->subMonth()->startOfMonth();
            $previousEndDate = Carbon::parse($startDate)->subMonth()->endOfMonth();

            // Calculate income for the previous period
            $incomePrevious = Appointment::query()
                ->whereDate('appointment_date', '>=', $previousStartDate)
                ->whereDate('appointment_date', '<=', $previousEndDate)
                ->sum('total_fee');
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

            // Calculate expense for the previous period
            $expensePrevious = Purchaselog::query()
                ->whereDate('purchase_date', '>=', $previousStartDate)
                ->whereDate('purchase_date', '<=', $previousEndDate)
                ->sum('total_expense');
            // Calculate expense Comparison in percentage
            if ($expensePrevious != 0 && $expenseCurrent != 0) {
                if ($expenseCurrent > $expensePrevious) {
                    $expenseChangePercentage = (($expenseCurrent - $expensePrevious) / $expenseCurrent) * 100;
                    $expenseStatus = true;
                } else {
                    $expenseChangePercentage = (($expensePrevious - $expenseCurrent) / $expensePrevious) * 100;
                    $expenseStatus = false;
                }
            } else {
                $expenseChangePercentage = ($expenseCurrent > 0) ? 100 : 0;
            }

            //Calculate profit for the previous period
            $profitPrevious = $incomePrevious - $expensePrevious;
            // Calculate profit Comparison in percentage
            if ($profitPrevious != 0 && $profitCurrent != 0) {
                if ($profitCurrent > $profitPrevious) {
                    $profitChangePercentage = (($profitCurrent - $profitPrevious) / $profitCurrent) * 100;
                    $profitStatus = true;
                } else {
                    $profitChangePercentage = (($profitPrevious - $profitCurrent) / $profitPrevious) * 100;
                    $profitStatus = false;
                }
                $profitChangePercentage = (($profitCurrent - $profitPrevious) / $profitCurrent) * 100;
            } else {
                $profitChangePercentage = ($profitCurrent > 0) ? 100 : 0;
            }
        } else {
            $incomeCurrent = 0;
            $expenseCurrent = 0;
        }

        // $formatNumber = function (int $number): string {
        //     if ($number < 1000) {
        //         return (string) Number::format($number, 0);
        //     }

        //     if ($number < 1000000) {
        //         return Number::format($number / 1000, 2) . 'k';
        //     }

        //     return Number::format($number / 1000000, 2) . 'm';
        // };

        $data_E = Trend::model(Purchaselog::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('purchase_date')
            ->perMonth()
            ->sum('total_expense');

        $data_I = Trend::model(Appointment::class)
            ->between(
                //get data from last year
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->sum('total_fee');
        //dd($data_I->map(fn (TrendValue $value) => $value->aggregate)->toArray());
        return [
            Stat::make('Total Income', $incomeCurrent)
                ->chart($data_I->map(fn (TrendValue $value) => $value->aggregate)->toArray())
                ->description(($incomeStatus ? 'Increase ' : 'Decrease ') . Number::format($incomeChangePercentage, 2) . ' % compared to last month')
                ->descriptionIcon($incomeStatus ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color(($incomeStatus == true) ? 'success' : 'danger'),
            Stat::make('Total Expense', $expenseCurrent)
                ->chart($data_E->map(fn (TrendValue $value) => $value->aggregate)->toArray())
                ->description(($expenseStatus ? 'Increase ' : 'Decrease ') . Number::format($expenseChangePercentage, 2) . ' % compared to last month')
                ->descriptionIcon($expenseStatus ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($expenseStatus ? 'danger' : 'success'),
            Stat::make('Total Profit',  $profitCurrent)
                ->description(($profitStatus ? 'Increase ' : 'Decrease ') . Number::format($profitChangePercentage, 2) . ' % compared to last month')
                ->descriptionIcon($profitStatus ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color(($profitStatus == true) ? 'success' : 'danger'),

        ];
    }
}
