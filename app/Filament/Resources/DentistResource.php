<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DentistResource\Pages;
use App\Filament\Resources\DentistResource\RelationManagers\AppointmentRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DentistResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'healthicons-o-doctor-male';

    protected static ?string $label = 'Dentists';

    protected static ?string $modelLabel = 'Dentists';

    protected static ?string $navigationGroup = 'People';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Dentists';

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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                //New Columns
                Tables\Columns\TextColumn::make('role.name')
                ->label('Role'),

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
            ])->where('role_id', 2)
            ;
    }
}
