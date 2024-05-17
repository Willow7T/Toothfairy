<?php

namespace App\Filament\Widgets;

use App\Models\Purchaselog;
use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SummaryChart extends ChartWidget
{ protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Income Expense Chart';

    protected static bool $isLazy = true;

    protected int | string | array $columnSpan = 2;

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {

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
                start: now()->subYear()->startOfYear(),
                end: now()->subYear()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->sum('total_fee');
        return [
            //'labels' => $data->map(fn (TrendValue $value) => $value->date),
            'datasets' => [
                [
                    'label' => 'Expense',
                    'data' => $data_E->map(fn (TrendValue $value) => $value->aggregate),
                    //purple
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 0.8)',
                ],
                [
                    'label' => 'Income',
                    'data' => $data_I->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(99, 255, 132, 0.2)',
                    'borderColor' => 'rgba(99, 225, 132, 0.8)', 
                ],

            ],
            //            'labels' => $data->map(fn (TrendValue $value) => $value->date),

            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
    protected function getType(): string
    {
        return 'line';
    }
}
