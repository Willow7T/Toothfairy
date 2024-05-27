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
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;



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
                            ->createOptionForm(User::getPatientform())
                            ->createOptionAction(
                                fn (Action $action) => $action
                                ->mutateFormDataUsing(function (array $data): array {
                                    $data['role_id'] = 3;
                                    $data['password'] = 'password';
                                    return $data;
                                })
                            )
                            ->editOptionForm(User::getPatientform())
                            ->searchable()
                            ->columnSpanFull()
                            ->options(
                                User::orderBy('updated_at', 'desc')
                                    ->where('role_id', 3)->get()
                                    ->mapWithKeys(function ($patient) {
                                        $age = $patient->userBio->age ?? 'N/A';
                                        return [$patient->id => "{$patient->name} (Age: {$age})"];
                                    })
                            )
                            ->getSearchResultsUsing(fn (string $search): array =>
                                User::searchPatients($search)->toArray())
                            ->required()
                            ->hint(new HtmlString('
                            <p>Search with name and age. To search with age use<span class="text-primary-400">" +"</span>before the typing the age.</p>
                            <p>Example: type <span>"William +25"</span> to search 25 years old William.</p>
                            <p>Keys: <kbd class="min-h-[30px] inline-flex justify-center items-center py-1 px-1.5 bg-white border border-gray-200 font-fira text-sm text-primary-500 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,0.08)]"
                            >space</kbd><span class="text-primary-400"> + </span>
                            <kbd class="min-h-[30px] inline-flex justify-center items-center py-1 px-1.5 bg-white border border-gray-200 font-fira text-sm text-primary-500 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,0.08)]"
                            >+</kbd>
                            </p>
                            '))  
                            ->loadingMessage('Loading patients...'),
                        Select::make('dentist_id')
                            ->label('Dentist')
                            ->columnSpanFull()
                            //user role must be 2 (dentist) relation
                            ->relationship('dentist', 'name')
                            //only role 2
                            ->options(User::where('role_id', 2)->get()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            // ->extraAttributes([])
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
                            ->createOptionForm(Treatment::getForm())
                            ->editOptionForm(Treatment::getForm())
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
                    Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                        //->slideOver(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
            'view' => Pages\ViewAppointment::route('/{record}'),

        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
