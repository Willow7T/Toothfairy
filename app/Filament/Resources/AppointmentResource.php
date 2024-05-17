<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Termwind\Components\Raw;


class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $modelLabel = 'Appointments';

    protected static ?string $navigationGroup = 'Transactions';

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
                            ->live(onBlur: true)
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
                                $set('price', $treatment->price_max);
                            })
                            ->required(),
                        Fieldset::make('Price Range')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $price = $get('price');
                                $quantity = $get('quantity');
                                $set('calculated_fee', $price * $quantity);
                            })
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
                                    ->required(),
                                TextInput::make('price')
                                    ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
                                    ->label('Price')
                                    ->numeric()
                                    ->suffix('kyats')
                                    ->default(0)
                                    ->prefixIcon('heroicon-o-banknotes')
                                    ->required(),
                            ]),
                        Placeholder::make('calculated_fee')
                            ->label('Calculated Fee')
                            ->content(function (Get $get): string {
                                $price = $get('price');
                                $quantity = $get('quantity');
                                return number_format($price * $quantity) . ' kyats';
                            }),

                    ]),
                Fieldset::make('Discount')
                    ->schema([
                        TextInput::make('discount')
                            ->label('Discount')
                            ->numeric()->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->default('0')
                            ->minValue(0)
                            ->suffix('kyats')
                            ->prefixIcon('heroicon-o-currency-dollar')
                            ->required(),

                        TextInput::make('discount_percentage')
                            ->label('Discount Percentage')
                            ->numeric()->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->default('0')
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->prefixIcon('heroicon-o-currency-dollar')
                            ->required(),

                    ]),

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
        //get patient age
        // $table->column('patient.age', function (Appointment $record) {

        // });
        return $table
            ->columns([
                    TextColumn::make('appointment_date')
                        ->date()
                        ->label('Appointment Date'),
                    TextColumn::make('dentist.name'),

                        TextColumn::make('patient.name'),
                        TextColumn::make('patient.userbio.age')
                            ->label('Age')
                            ->suffix(' years'),

                        TextColumn::make('calculated_fee')
                            ->label('Without Discount')
                            ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                        TextColumn::make('discount')
                            ->label('Discount')
                            ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),
                        TextColumn::make('discount_percentage')
                            ->label('Discount Percentage')
                            ->numeric()
                            //remove decimal
                            ->suffix('%')->toggleable(isToggledHiddenByDefault: true),
                        TextColumn::make('total_fee')
                            ->label('Total Cost')
                            ->suffix(' kyats')->toggleable(isToggledHiddenByDefault: true),

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
                            ->sortable()
                            ->toggleable(isToggledHiddenByDefault: true),
                        TextColumn::make('updated_at')
                            ->label('Updated At')
                            ->since()
                            ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([
                // Filter::make('is_featured')
                //     ->query(fn (Builder $query) => $query->where('is_featured', true)),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'view' => Pages\ViewAppointment::route('/{record}'),

        ];
    }
}
