<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientsResource\RelationManagers\AppointmentRelationManager;
use App\Filament\Resources\PatientsResource\Pages;
use App\Models\User;
use Carbon\Carbon;
use Cheesegrits\FilamentPhoneNumbers\Columns\PhoneNumberColumn;
use Cheesegrits\FilamentPhoneNumbers\Enums\PhoneFormat;
use Filament\Forms\Form;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = User::class;


    protected static ?string $modelLabel = 'Patients';

    protected static ?string $navigationGroup = 'People';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(User::getPatientform());
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
            'create' => Pages\CreatePatient::route('/create'),
            'view' => Pages\ViewPatient::route('/{record}'),
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
