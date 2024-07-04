<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Models\Treatment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Fieldset::make('Appointment Information')
                    ->columnSpan([1, 'md' => 4])
                    ->schema([
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
                            ->minDate(now())
                            ->maxDate(now()->addYear(1))
                            ->required(),
                        TextInput::make('status')
                            ->label('Status')
                            ->disabled()
                            ->default('pending')
                            ->required(),
                        Repeater::make('treatments')
                            ->relationship('treatments')
                            ->columnSpan([1, 'md' => 4])
                            ->addActionLabel('Add Treatments')
                            ->schema([
                                Select::make('treatment_id')
                                    ->label('Treatment')
                                    ->relationship('treatment', 'name')
                                    ->options(Treatment::where('is_register', true)->orderBy('updated_at', 'desc')->get()->pluck('name', 'id'))
                                    ->loadingMessage('Loading treatments...')
                                    ->required(),
                            ])


                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('appointment_date')
                    ->date()
                    ->label('Appointment Date'),
                TextColumn::make('dentist.name')
                    ->searchable(),

                TextColumn::make('patient.name')
                    ->searchable(),
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

                TextColumn::make('status')
                    ->label('Status')
                    ->toggleable(),

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
            ->filters([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            // 'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('patient_id', auth()->user()->id);
    }
}
