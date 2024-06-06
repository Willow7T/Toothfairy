<?php

namespace App\Filament\Widgets;

use App\Models\Purchaselog;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ExpenseChart extends ChartWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Expense Chart';

    protected static bool $isLazy = true;

    protected function getData(): array
    {
        $data = Trend::model(Purchaselog::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('purchase_date')
            ->perMonth()
            ->sum('total_expense');

        $data_2 = Trend::model(Purchaselog::class)
            ->between(
                start: now()->subYear()->startOfYear(),
                end: now()->subYear()->endOfYear(),
            )
            ->dateColumn('purchase_date')
            ->perMonth()
            ->sum('total_expense');
        return [
            'datasets' => [
                [
                    'label' => '2023',
                    'data' => $data_2->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(99, 132, 255, 0.2)',
                    'borderColor' => 'rgba(99, 132, 255, 0.8)',
                ],
                [
                    'label' => '2024',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(225, 99, 132, 0.8)', //green
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    public function getDescription(): ?string
    {
        return 'Expense Table for Last Year and This Year';
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
