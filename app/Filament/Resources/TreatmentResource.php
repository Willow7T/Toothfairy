<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentResource\Pages;
//use App\Filament\Resources\TreatmentResource\RelationManagers;
use App\Models\Treatment;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Fieldset as ComponentsFieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'ri-health-book-line';

    protected static ?string $modelLabel = 'Treatments';

    protected static ?string $navigationGroup = 'Items';

    protected static ?int $navigationSort = 0;




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('description')
                    ->rows(1)
                    ->autosize(),

                Fieldset::make('Price Range')
                    ->columns(2)
                    ->schema([
                        TextInput::make('price_min')
                            ->label('Price Minimum')
                            ->numeric()->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required()
                            ->prefixIcon('heroicon-o-banknotes')
                            ->suffix('kyats'),
                        TextInput::make('price_max')
                            ->label('Price Maxium')
                            ->numeric()->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->required()
                            ->prefixIcon('heroicon-o-banknotes')
                            ->suffix('kyats'),
                    ]),
                FileUpload::make('edufile')
                    ->directory('EduUploads')
                    ->label('Educational File')
                    ->previewable(false)
                    ->moveFiles()
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxFiles(1)
                    ->helperText('Upload a docx file for educational purposes')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                ColumnGroup::make('Price Range', [
                    Tables\Columns\TextColumn::make('price_min')
                        ->suffix(' kyats')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('price_max')
                        ->suffix(' kyats')
                        ->sortable(),
                ]),
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
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
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                ComponentsFieldset::make('Price Range')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('price_min')
                            ->label('Price Minimum')
                            ->suffix(' kyats'),
                        TextEntry::make('price_max')
                            ->label('Price Maximum')
                            ->suffix(' kyats'),
                    ])
                    ->hidden(function () {
                        // Get the current authenticated user
                        $user = auth()->user();
                
                        // Hide the fieldset if the user's role is 'patient'
                        return $user->role === 'patient';
                    }),



            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'view' => Pages\ViewTreatment::route('/{record}'),
            // 'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
