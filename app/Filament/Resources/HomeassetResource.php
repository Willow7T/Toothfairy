<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeassetResource\Pages;
use App\Filament\Resources\HomeassetResource\RelationManagers;
use App\Models\Homeasset;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeassetResource extends Resource
{
    protected static ?string $model = Homeasset::class;

    protected static ?string $pluralModelLabel = 'Home & Welcome Control';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(25),

                Forms\Components\Fieldset::make('Image')
                    ->label('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Big Image')
                            ->image()
                            ->directory('Home')
                            ->required()
                            ->imageEditor()
                            ->downloadable()
                            ->maxSize(30000)
                            ->hint('This will be the wallpaper in the home page card.')
                            ->previewable(),
                        Forms\Components\FileUpload::make('image2')
                            ->label('Small Image')
                            ->image()
                            ->directory('Home')
                            ->required()
                            ->imageEditor()
                            ->downloadable()
                            ->maxSize(30000)
                            ->hint('This will be the logo in the home page card.')
                            ->previewable(),
                    ]),
                Forms\Components\Fieldset::make('Text')
                    ->label('Text')
                    ->schema([
                        Forms\Components\TextInput::make('h1')
                            ->maxLength(25)
                            ->required(),
                        Forms\Components\TextInput::make('h2')
                            ->maxLength(50)
                            ->required(),
                        Forms\Components\TextInput::make('p')
                            ->maxLength(30)
                            ->required(),
                    ]),

                Forms\Components\Toggle::make('is_active')
                    ->inline(false)
                    ->hint('Whether these Home Assets are active or not. It there are multiple active it will randomly take one set.')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\ImageColumn::make('image2'),
                Tables\Columns\TextColumn::make('h1'),
                Tables\Columns\TextColumn::make('h2'),
                Tables\Columns\TextColumn::make('p'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
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
            'index' => Pages\ListHomeassets::route('/'),
            'create' => Pages\CreateHomeasset::route('/create'),
            //'edit' => Pages\EditHomeasset::route('/{record}/edit'),
        ];
    }
}
