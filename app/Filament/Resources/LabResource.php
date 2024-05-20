<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabResource\Pages;
use App\Filament\Resources\LabResource\RelationManagers;
use App\Models\Lab;
use Cheesegrits\FilamentPhoneNumbers\Columns\PhoneNumberColumn;
use Cheesegrits\FilamentPhoneNumbers\Enums\PhoneFormat;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LabResource extends Resource
{
    protected static ?string $model = Lab::class;
   
    protected static ?string $navigationIcon = 'fluentui-dentist-16-o';

    protected static ?string $modelLabel = 'Lab';

    //protected static ?string $navigationGroup = 'Items';

    //protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Lab name')
                    ->required()
                    ->maxLength(30),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique('labs', 'email')
                    ->prefixIcon('heroicon-o-envelope'),
                TextInput::make('address')
                    ->label('Address'),
                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->prefix('https://')
                    ->prefixIcon('heroicon-s-globe-alt'),
                PhoneNumber::make('phone_no')
                ->label('Phone number')
                ->prefix('(+95 / 0)')
                ->suffix('Myanmar')
                ->region('MM'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Lab name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('address')
                    ->label('Address'),
                TextColumn::make('website')
                    ->label('Website')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                PhoneNumberColumn::make('phone_no')
                    ->label('Phone number')
                    ->displayFormat(PhoneFormat::INTERNATIONAL)
                    ->dial(),
                TextColumn::make('created_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()->toggleable(isToggledHiddenByDefault: true),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabs::route('/'),
            'create' => Pages\CreateLab::route('/create'),
            'view' => Pages\ViewLab::route('/{record}'),
           // 'edit' => Pages\EditLab::route('/{record}/edit'),
        ];
    }
}
