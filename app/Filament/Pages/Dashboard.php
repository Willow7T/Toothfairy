<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\HtmlString;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->default(now()->startOfMonth()->toDateString())
                            ->native(false),
                        DatePicker::make('endDate')
                            ->default(now()->endOfMonth()->toDateString())
                            ->native(false),
                        Select::make('is_show')
                            ->label('Show Data')
                            ->live()
                            ->default(false)
                            ->options([
                                0 => 'No',
                                1 => 'Yes',
                            ])
                            ->afterStateUpdated(
                                fn (Set $set, Get $get)
                                => $set('is_show', $get('is_show') ? 1 : 0)
                            ),
                    ])->columns(3)
            ]);
    }
}
