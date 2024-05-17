<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class IncomeChart extends ChartWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?string $heading = 'Income Chart';

    protected static bool $isLazy = true;



    protected function getData(): array
    {

        $data = Trend::model(Appointment::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->dateColumn('appointment_date')
            ->perMonth()
            ->sum('total_fee');

        $data_2 = Trend::model(Appointment::class)
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
                    'label' => '2023',
                    'data' => $data_2->map(fn (TrendValue $value) => $value->aggregate),
                    //purple
                    'backgroundColor' => 'rgba(99, 132, 255, 0.2)',
                    'borderColor' => 'rgba(99, 132, 255, 0.8)',
                ],
                [
                    'label' => '2024',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(99, 225, 132, 0.2)',
                    'borderColor' => 'rgba(99, 225, 132, 0.8)', 
                ],

            ],
            //            'labels' => $data->map(fn (TrendValue $value) => $value->date),

            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    public function getDescription(): ?string
    {
        return 'Income Table for Last Year and This Year';

    }
   

    protected function getOptions(): array
    {
        return [
            'plugins' => [
               
            ],
            
        
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
