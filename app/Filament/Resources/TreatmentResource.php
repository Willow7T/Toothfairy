<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreatmentResource\Pages;
use App\Livewire\WordRender;
use App\Models\Treatment;
use Dompdf\FrameDecorator\Text;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\Fieldset as ComponentsFieldset;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
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

    //  protected static ?string $navigationGroup = 'Items';

    //protected static ?int $navigationSort = 0;




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
                Toggle::make('is_register')
                    ->hint('Register this treatment to allow patient to choose during thier booking process')
                    ->default(false)
                    ->required(),


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
                    ->columnSpanFull()
                    ->previewable(false)
                    ->openable()
                    ->moveFiles()
                    ->deletable()
                    //only docx file types are accepted
                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxFiles(1)
                    ->helperText('Upload a .docx file for educational purposes'),
                FileUpload::make('image')
                    ->image()
                    ->directory('Treatments')
                    ->imageEditor()
                    ->downloadable()
                    ->maxSize(30000)
                    ->previewable(),
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
                        ->sortable()
                        ->hidden(TreatmentResource::hiddenfrompatients()),
                    Tables\Columns\TextColumn::make('price_max')
                        ->suffix(' kyats')
                        ->sortable()
                        ->hidden(TreatmentResource::hiddenfrompatients()),
                ]),
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->toggleable(!(TreatmentResource::hiddenfrompatients()))
                // ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->hidden(TreatmentResource::hiddenfrompatients()),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->slideOver(),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->hidden(TreatmentResource::hiddenfrompatients()),
                Tables\Actions\ViewAction::make()->hidden(function () {
                    // Get the current authenticated user
                    $user = auth()->user();
                    //Not Hide the fieldset if the user's role is 'patient'
                    return !($user->role->name === 'patient');
                }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ])->hidden(TreatmentResource::hiddenfrompatients()),
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
                    ->hidden(TreatmentResource::hiddenfrompatients()),
                Livewire::make(WordRender::class, ['edufile' => 'edufile'])
                    ->label('Educational File')
                    ->columnSpanFull(),
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
    protected static function hiddenfrompatients(): bool
    {
        // Get the current authenticated user
        $user = auth()->user();

        // Hide the fieldset if the user's role is 'patient'
        return $user->role->name === 'patient';
    }
}
