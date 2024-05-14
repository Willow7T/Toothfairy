<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use App\Models\Lab;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $modelLabel = 'Lab Item';

    protected static ?string $navigationGroup = 'Items';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Item name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(30),
                Repeater::make('labs')
                    ->relationship('labs')
                    ->hint('More Labs offers same item? Then press "Add Labs" button')
                    ->addActionLabel('Add Labs')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('lab_id')
                            ->label('Lab')
                            //user role must be 3 (patient) relation
                            ->relationship('labs', 'name')
                            ->options(Lab::get()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->loadingMessage('Loading Labs...'),
                        TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->prefixIcon('heroicon-o-banknotes')
                            ->suffix('kyats'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
           // 'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
