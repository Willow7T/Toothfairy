<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DentistResource\Pages;
use App\Filament\Resources\DentistResource\RelationManagers\AppointmentRelationManager;
use App\Models\User;
use Cheesegrits\FilamentPhoneNumbers\Columns\PhoneNumberColumn;
use Cheesegrits\FilamentPhoneNumbers\Enums\PhoneFormat;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DentistResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Dentists';

    protected static ?string $navigationGroup = 'People';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique('users', 'email')
                    ->prefixIcon('heroicon-o-envelope')
                    ->hiddenOn('edit'),
                Fieldset::make('Dentist Bio')
                    ->relationship('dentistBio')
                    ->schema([
                        Forms\Components\TextInput::make('age')
                            ->label('Age')
                            ->suffix('years')
                            ->minValue(21)
                            ->maxValue(90)
                            ->numeric()
                            ->prefixIcon('iconpark-birthdaycake-o'),
                        Forms\Components\TextInput::make('qualification')
                            ->label('Qualification')
                            ->prefixIcon('fas-graduation-cap'),
                        Forms\Components\TextInput::make('experience')
                            ->label('Experience')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(90)
                            ->suffix('years')
                            ->prefixIcon('iconpark-briefcase-o')
                            ->hint('In years'),
                        PhoneNumber::make('phone_no')
                            ->label('Phone number')
                            ->prefix('(+95 / 0)')
                            ->suffix('Myanmar')
                            ->region('MM'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->copyable(),

                //New Columns
                Tables\Columns\TextColumn::make('dentistBio.age')
                    ->label('Age'),
                Tables\Columns\TextColumn::make('dentistBio.qualification')
                    ->label('Qualification'),
                    tables\Columns\TextColumn::make('dentistBio.experience')
                    ->label('Experience')
                    ->suffix('years'),
                
                PhoneNumberColumn::make('dentistBio.phone_no')
                    ->label('Phone number')
                    ->displayFormat(PhoneFormat::INTERNATIONAL)
                    ->dial(),

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
        return [
            AppointmentRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDentists::route('/'),
            'create' => Pages\CreateDentist::route('/create'),
            'view' => Pages\ViewDentist::route('/{record}'),
            //'edit' => Pages\EditDentist::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->where('role_id', 2);
    }
}
