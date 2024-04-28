<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientsResource\Pages;
use App\Models\Treatment;
use App\Models\User;
use Cheesegrits\FilamentPhoneNumbers\Columns\PhoneNumberColumn;
use Cheesegrits\FilamentPhoneNumbers\Enums\PhoneFormat;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Checkbox;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Contracts\Support\Htmlable;


class PatientsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'vaadin-dental-chair';

    protected static ?string $label = 'Patients';

    protected static ?string $modelLabel = 'Patients';

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $navigationLabel = 'Patients';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //fields from user
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique('users', 'email')
                    ->prefixIcon('heroicon-o-envelope')
                    ->hiddenOn('edit'),

                //Fields from user_bio
                Fieldset::make('User Bio')
                    ->relationship('userBio')
                    ->schema([
                        DatePicker::make('birthday')
                            ->label('Birthday')
                            ->after('1900-01-01')
                            ->before('today')
                            ->native(false),
                        TextInput::make('age')
                            ->label('Age')
                            ->type('number'),
                        Select::make('sex')
                            ->label('Sex')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ]),
                        PhoneNumber::make('phone_no')
                            ->label('Phone number')
                            ->prefix('+95')
                            ->region('MM'),
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(5),
                        Textarea::make('medical_info')
                            ->label('Medical Info')
                            ->rows(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->iconPosition(IconPosition::After)
                    ->iconColor('primary')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                // Add columns for user bio
                TextColumn::make('userBio.birthday')
                    ->label('Birthday'),
                TextColumn::make('userBio.age')
                    ->label('Age')
                    ->sortable(true),
                IconColumn::make('userBio.sex')
                    ->label('Sex')
                    ->icon(fn (string $state): string => match ($state) {
                        'male' => 'eos-male',
                        'female' => 'eos-female',
                        'other' => 'eos-question-mark',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        'other' => 'gray',
                        default => 'gray',
                    })
                    ->size(IconColumn\IconColumnSize::Medium)
                    ->sortable(true),
                PhoneNumberColumn::make('userBio.phone_no')
                    ->label('Phone number')
                    ->displayFormat(PhoneFormat::INTERNATIONAL)
                    ->dial(),
                TextColumn::make('userBio.address')
                    ->label('Address')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('userBio.medical_info')
                    ->label('Medical Info')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatients::route('/create'),
            'view' => Pages\ViewPatients::route('/{record}'),
            // 'edit' => Pages\EditPatients::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->where('role_id', 3);
    }
}
