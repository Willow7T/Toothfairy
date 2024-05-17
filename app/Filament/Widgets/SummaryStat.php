<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Purchaselog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SummaryStat extends BaseWidget
{

    protected function getStats(): array
    {
        $lasyearincome = Appointment::whereYear('appointment_date', now()->subYear()->year)->sum('total_fee');

        $income = Appointment::whereYear('appointment_date', now()->year)->sum('total_fee');

        $expense = Purchaselog::whereYear('purchase_date', now()->year)->sum('total_expense');

        $lastyearexpense = Purchaselog::whereYear('purchase_date', now()->subYear()->year)->sum('total_expense');
        return [
            Stat::make('Total Income', $income),
            Stat::make('Last Year Income', $lasyearincome),
            Stat::make('Total Expense', $expense),
            Stat::make('Last Year Expesne', $lastyearexpense),
        ];
    }

}
