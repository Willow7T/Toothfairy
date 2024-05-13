<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientsResource\RelationManagers\AppointmentRelationManager;
use App\Filament\Resources\PatientsResource\Pages;
use App\Models\Treatment;
use App\Models\User;
use Carbon\Carbon;
use Cheesegrits\FilamentPhoneNumbers\Columns\PhoneNumberColumn;
use Cheesegrits\FilamentPhoneNumbers\Enums\PhoneFormat;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'ri-contacts-book-3-line';

    protected static ?string $label = 'Patients';

    protected static ?string $modelLabel = 'Patients';

    protected static ?string $navigationGroup = 'People';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Patients';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //fields from user
                TextInput::make('name')
                    ->required()
                    ->prefixIcon('heroicon-o-user')
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
                            ->prefixIcon('iconpark-birthdaycake-o')
                            ->after('1900-01-01')
                            ->before('today')
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $birthday = $get('birthday');
                                $age = Carbon::parse($birthday)->age;
                                $set('age', $age);
                            }),
                        TextInput::make('age')
                            ->label('Age')
                            ->live()
                            ->suffix('years')
                            ->numeric()
                            ->prefixIcon('iconpark-birthdaycake-o')
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $age = $get('age');
                                $birthday = Carbon::now()->subYears($age)->toDateString();
                                $set('birthday', $birthday);
                            })
                            ->hint('This field is automatically calculated based on the birthday field.'),
                        Select::make('sex')
                            ->label('Sex')
                            ->prefixIcon('bi-gender-ambiguous')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ]),
                        Textarea::make('medical_info')
                            ->label('Medical Info')
                            ->rows(1)
                            ->autosize(),
                        Fieldset::make('Contact Information')
                            ->schema([
                                Textarea::make('address')
                                    ->label('Address')
                                    ->rows(1)
                                    ->autosize(),
                                PhoneNumber::make('phone_no')
                                    ->label('Phone number')
                                    ->prefix('(+95 / 0)')
                                    ->suffix('Myanmar')
                                    ->region('MM'),
                            ])



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
                    ->date()
                    ->label('Birthday'),
                TextColumn::make('userBio.age')
                    ->label('Age')
                    ->sortable(true),
                IconColumn::make('userBio.sex')
                    ->label('Sex')
                    ->icon(fn (string $state): string => match ($state) {
                        'male' => 'bi-gender-male',
                        'female' => 'bi-gender-female',
                        'other' => 'bi-gender-ambiguous',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        'other' => 'gray',
                        default => 'gray',
                    })
                    ->size(IconColumn\IconColumnSize::Medium)
                    ->sortable(true),
                ColumnGroup::make('Contact Information', [
                    PhoneNumberColumn::make('userBio.phone_no')
                        ->label('Phone number')
                        ->displayFormat(PhoneFormat::INTERNATIONAL)
                        ->dial(),
                    TextColumn::make('userBio.address')
                        ->label('Address')
                        ->toggleable(isToggledHiddenByDefault: true),

                ]),
                // PhoneNumberColumn::make('userBio.phone_no')
                //     ->label('Phone number')
                //     ->displayFormat(PhoneFormat::INTERNATIONAL)
                //     ->dial(),
                // TextColumn::make('userBio.address')
                //     ->label('Address')
                //     ->toggleable(isToggledHiddenByDefault: true),
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
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                IconEntry::make('userBio.sex')
                    ->label('Sex')
                    ->icon(fn (string $state): string => match ($state) {
                        'male' => 'bi-gender-male',
                        'female' => 'bi-gender-female',
                        'other' => 'bi-gender-ambiguous',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        'other' => 'gray',
                        default => 'gray',
                    }),
                TextEntry::make('userBio.birthday')
                    ->label('Birthday')
                    ->date(),
                TextEntry::make('userBio.age')
                    ->label('Age')
                    ->numeric(),
                

            ]);
    }

    public static function getRelations(): array
    {
        return [
           AppointmentRelationManager::class
        ];
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
