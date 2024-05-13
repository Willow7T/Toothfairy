<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'vaadin-dental-chair';

    protected static ?string $label = 'Appointments';

    protected static ?string $modelLabel = 'Appointments';

    protected static ?string $navigationGroup = 'Transaction';

    protected static ?string $navigationLabel = 'Appointments';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Appointment Information')
                    ->columnSpan(4)
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            //user role must be 3 (patient) relation
                            ->relationship('patient', 'name')
                            ->options(User::where('role_id', 3)->get()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->loadingMessage('Loading patients...'),
                        Select::make('dentist_id')
                            ->label('Dentist')
                            //user role must be 2 (dentist) relation
                            ->relationship('dentist', 'name')
                            //only role 2
                            ->options(User::where('role_id', 2)->get()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->loadingMessage('Loading dentists...'),
                        DatePicker::make('appointment_date')
                            ->label('Appointment Date')
                            ->default('today')
                            ->native(false)
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required(),
                    
                        ]),

                Repeater::make('treatments')
                    ->relationship('treatments')
                    ->columnSpan(4)
                    ->addActionLabel('Add Treatments')
                    ->grid(2)
                    ->defaultItems(2)
                    ->schema([
                        Select::make('treatment_id')
                            ->label('Treatment')
                            ->relationship('treatment', 'name')
                            ->live()
                            ->searchable()
                            //orderedby last update
                            ->options(Treatment::orderBy('updated_at', 'desc')->get()->pluck('name', 'id'))
                            ->loadingMessage('Loading treatments...')
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                //get the treatment price
                                $treatment_id = $get('treatment_id');
                                //write query to get price
                                $treatment = \App\Models\Treatment::find($treatment_id);
                                //update the placeholder field
                                $set('price_min', $treatment->price_min);
                                $set('price_max', $treatment->price_max);
                            })
                            ->required(),
                        Fieldset::make('Price Range')
                            ->schema([
                                Placeholder::make('price_min')
                                    ->label('Minimum Price')
                                    ->content(function (Get $get): string {
                                        return number_format($get('price_min')) . ' kyats';
                                    }),
                                Placeholder::make('price_max')
                                    ->label('Maximum Price')
                                    ->content(function (Get $get): string {
                                        return number_format($get('price_max')) . ' kyats';
                                    }),
                                TextInput::make('quantity')
                                    ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
                                    ->label('Quantity')
                                    ->numeric()
                                    ->default(1)
                                    // ->live(onBlur: true)
                                    // ->afterStateUpdated(function (Set $set, Get $get) {
                                    //     $price = $get('price');
                                    //     $quantity = $get('quantity');
                                    //     $set('calculated_fee', $price * $quantity);
                                    // })
                                    ->required(),
                                TextInput::make('price')
                                    ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
                                    ->label('Price')
                                    ->numeric()
                                    ->suffix('kyats')
                                    ->default(0)
                                    ->prefixIcon('heroicon-o-banknotes')
                                    // ->live(onBlur: true)
                                    // ->afterStateUpdated(function (Set $set, Get $get) {
                                    //     $price = $get('price');
                                    //     $quantity = $get('quantity');
                                    //     $set('calculated_fee', $price * $quantity);
                                    // })
                                    ->required(),
                                // Placeholder::make('calculated_fee')
                                //     ->label('Calculated Fee')
                                //     ->content(function (Get $get): string {
                                //         $price = $get('price');
                                //         $quantity = $get('quantity');
                                //         return number_format($price * $quantity) . ' kyats';
                                //     }),
                                ]),
           ]),
                TextInput::make('discount')
                    ->placeholder('Discount')
                    ->label('Discount')
                    ->numeric()
                    ->columnSpanFull()
                    ->default('0')
                    ->suffix('kyats')
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->required(),
                Textarea::make('description')
                    ->placeholder('Remarks')
                    ->label('Descritpion')
                    ->columnSpanFull()
                    ->autosize()
                    ->rows(2),


            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_date')
                    ->date()
                    ->label('Appointment Date'),
                TextColumn::make('dentist.name'),
                TextColumn::make('patient.name'),
                ColumnGroup::make('Treatments', [
                    TextColumn::make('treatments.treatment.name')
                        ->label('Treatment')
                        ->listWithLineBreaks()
                        ->bulleted()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('treatments.quantity')
                        ->label('Quantity')
                        ->listWithLineBreaks()
                        ->bulleted()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('treatments.price')
                        ->label('Price')
                        ->listWithLineBreaks()
                        ->bulleted()->toggleable(isToggledHiddenByDefault: true),
                ]),
                ColumnGroup::make('Price', [
                    TextColumn::make('calculated_fee')
                        ->label('Without Discount')
                        ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('discount')
                        ->label('Discount')
                        ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('total_fee')
                        ->label('Total Cost')
                        ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                ]),
                SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])->toggleable(),

                TextColumn::make('discription')
                    ->label('Remarks')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            //'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
