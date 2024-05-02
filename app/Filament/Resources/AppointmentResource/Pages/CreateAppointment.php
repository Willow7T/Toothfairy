<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;


class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;
    // protected function mutateFormDataBeforeCreate($record, array $data): array
    
}

// Fieldset::make('Appointment Information')
// ->columnSpan(4)
// ->schema([
//     Select::make('patient_id')
//         ->label('Patient')
//         //user role must be 3 (patient) relation
//         ->relationship('patient', 'name')
//         ->required(),
//     Select::make('dentist_id')
//         ->label('Dentist')
//         //user role must be 2 (dentist) relation
//         ->relationship('dentist', 'name')
//         ->required(),
//     DatePicker::make('appointment_date')
//         ->label('Appointment Date')
//         ->default('today')
//         ->native(false)
//         ->required(),
//     Select::make('status')
//         ->label('Status')
//         ->options([
//             'pending' => 'Pending',
//             'completed' => 'Completed',
//             'cancelled' => 'Cancelled',
//         ])
//         ->default('pending')
//         ->required(),
// ]),

// Repeater::make('treatments')
// ->relationship('treatments')
// ->columnSpan(4)
// ->addActionLabel('Add Treatments')
// ->grid(2)
// ->defaultItems(2)
// ->schema([
//     Select::make('treatment_id')
//         ->label('Treatment')
//         ->relationship('treatment', 'name')
//         ->live()
//         ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
//             //get the treatment price
//             $treatment_id = $get('treatment_id');
//             //write query to get price
//             $treatment = \App\Models\Treatment::find($treatment_id);
//             //update the placeholder field
//             $set('price_min', $treatment->price_min);
//             $set('price_max', $treatment->price_max);
//         })
//         ->required(),
//     Fieldset::make('Price Range')
//         ->schema([
//             Placeholder::make('price_min')
//                 ->label('Minimum Price')
//                 ->content(function (Get $get): string {
//                     return number_format($get('price_min')) . ' kyats';
//                 }),
//             Placeholder::make('price_max')
//                 ->label('Maximum Price')
//                 ->content(function (Get $get): string {
//                     return number_format($get('price_max')) . ' kyats';
//                 }),
//             TextInput::make('quantity')
//                 ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
//                 ->label('Quantity')
//                 ->numeric()
//                 ->default(1)
//                 ->afterStateUpdated(function (Set $set, Get $get) {
//                     $price = $get('price');
//                     $quantity = $get('quantity');
//                     $set('calculated_fee', $price * $quantity);
//                 })
//                 ->required(),
//             TextInput::make('price')
//                 ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
//                 ->label('Price')
//                 ->numeric()
//                 ->suffix('kyats')
//                 ->default(0)
//                 ->prefixIcon('heroicon-o-banknotes')
//                 ->live(onBlur: true)
//                 ->afterStateUpdated(function (Set $set, Get $get) {
//                     $price = $get('price');
//                     $quantity = $get('quantity');
//                     $set('calculated_fee', $price * $quantity);
//                 })
//                 ->required(),
//             Placeholder::make('calculated_fee')
//                 ->label('Calculated Fee')
//                 ->content(function (Get $get): string {
//                     $price = $get('price');
//                     $quantity = $get('quantity');
//                     return number_format($price * $quantity) . ' kyats';
//                 }),
//         ]),

// ]),
// TextInput::make('discount')
// ->label('Discount')
// ->numeric()
// ->suffix('kyats')
// ->prefixIcon('heroicon-o-currency-dollar')
// ->required(),
