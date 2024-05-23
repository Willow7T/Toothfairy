<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardResource\Pages;
//use App\Filament\Resources\CardResource\RelationManagers;
use App\Models\Card;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    //protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Cards';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->autosize(),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('Cards')
                    ->required()
                    ->imageEditor()
                    ->downloadable()
                    ->columnSpanFull()
                   // ->maxSize('20000')
                    ->previewable(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->columnSpanFull()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Active')
                    ->columnSpanFull()
                    ->default(true)
                    ->inline(false)
                    ->hint('This will determine if the card is visible on the front end.'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('content')
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
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
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            // 'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }
}
