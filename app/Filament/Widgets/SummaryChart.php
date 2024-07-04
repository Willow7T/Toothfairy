<?php

namespace App\Filament\Widgets;

use App\Models\Purchaselog;
use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SummaryChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Income Expense Chart';

    protected static bool $isLazy = true;

    protected int | string | array $columnSpan = [1, 'md' => 2];

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {

        $is_show = $this->filters['is_show'];

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
        return [
            'datasets' => [
                [
                    'label' => 'Expense',
                    'data' => $is_show ? $data_E->map(fn (TrendValue $value) => $value->aggregate) : [],
                    'backgroundColor' => 'rgba(255, 99, 132, .5)',
                    'borderColor' => 'rgba(255, 99, 132, 0.8)',
                    'color' => 'rgba(255, 99, 132)',
                    'fill' => 'start',
                    'tension' => '0.3',
                ],
                [
                    'label' => 'Income',
                    'data' => $is_show ? $data_I->map(fn (TrendValue $value) => $value->aggregate) : [],
                    'backgroundColor' => 'rgba(99, 255, 132, .5)',
                    'borderColor' => 'rgba(99, 225, 132, 0.8)',
                    'color' => 'rgba(99, 255, 132)',
                    'fill' => 'start',
                    'tension' => '0.3',
                ],

            ],

            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
    protected function getType(): string
    {
        return 'line';
    }
}
