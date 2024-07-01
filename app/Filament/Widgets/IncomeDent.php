<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeDent extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Income Chart';

    protected static bool $isLazy = true;

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $is_show = $this->filters['is_show'];
        $data = Trend::query(Appointment::where('dentist_id', auth()->user()->id))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->sum('total_fee');
        $data_2 = Trend::query(Appointment::where('dentist_id', auth()->user()->id))
            ->between(
                start: now()->subYear()->startOfYear(),
                end: now()->subYear()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->sum('total_fee');

        return [
            'datasets' => [
                [
                    'label' => '2023',
                    'data' => $is_show ? $data_2->map(fn (TrendValue $value) => $value->aggregate) : [],
                    'backgroundColor' => 'rgba(99, 132, 255, 0.2)',
                    'borderColor' => 'rgba(99, 132, 255, 0.8)',
                    'tension' => '0.3',
                ],
                [
                    'label' => '2024',
                    'data' => $is_show ? $data->map(fn (TrendValue $value) => $value->aggregate) : [],
                    'backgroundColor' => 'rgba(99, 225, 132, 0.2)',
                    'borderColor' => 'rgba(99, 225, 132, 0.8)',
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
    public function getDescription(): ?string
    {
        return 'Income Table for Last Year and This Year';
    }
}
