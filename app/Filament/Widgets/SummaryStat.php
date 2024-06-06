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

        if ($is_show == 1) {
            $income = Appointment::query()
                ->whereDate('appointment_date', '>=', $startDate)
                ->whereDate('appointment_date', '<=', $endDate)
                ->sum('total_fee');
            $expense = Purchaselog::query()
                ->whereDate('purchase_date', '>=', $startDate)
                ->whereDate('purchase_date', '<=', $endDate)
                ->sum('total_expense');
        } else {
            $income = 0;
            $expense = 0;
        }

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2) . 'k';
            }

            return Number::format($number / 1000000, 2) . 'm';
        };

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
            Stat::make('Total Income', $formatNumber($income))
                ->chart($data_I->map(fn (TrendValue $value) => $value->aggregate)->toArray())
                ->color('success'),
            Stat::make('Total Expense', $formatNumber($expense))
                ->chart($data_E->map(fn (TrendValue $value) => $value->aggregate)->toArray())
                ->color('danger'),
            Stat::make('Total Profit',  $formatNumber($income - $expense))
                ->color('primary'),

        ];
    }
}
