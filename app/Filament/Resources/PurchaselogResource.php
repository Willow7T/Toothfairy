<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaselogResource\Pages;
use App\Filament\Resources\PurchaselogResource\RelationManagers;
use App\Models\LabItem;
use App\Models\Purchaselog;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaselogResource extends Resource
{
    protected static ?string $model = Purchaselog::class;

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?string $modelLabel = 'Expenses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Purchase Information')
                    ->columnSpan(4)
                    ->schema([
                        DatePicker::make('purchase_date')
                            ->label('Purchase Date')
                            ->default('today')
                            ->native(false)
                            ->required(),
                        // Select::make('status')
                        //     ->label('Status')
                        //     ->options([
                        //         'pending' => 'Pending',
                        //         'completed' => 'Completed',
                        //         'cancelled' => 'Cancelled',
                        //     ])
                        //     ->default('pending')
                        //     ->required(),

                    ]),

                Repeater::make('purchaselog_id')
                    ->relationship('purchaselogitems')
                    ->columnSpan(4)
                    ->addActionLabel('Add Items')
                    ->grid(2)
                    ->defaultItems(2)
                    ->schema([
                        Select::make('labitem_id')
                            ->label('Item')
                            ->relationship('labitem', 'id')   
                            ->live(onBlur: true)
                            // ->searchable()
                            //orderedby last update
                            // ->getSearchResultsUsing(fn (string $search): array => LabItem::where('item.name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                            ->options(LabItem::orderBy('updated_at', 'desc')->get()->pluck('item.name', 'id'))
                            // ->getOptionLabelUsing(fn ($value): ?string => LabItem::find($value)?->item()->name)
                            ->loadingMessage('Loading items...')
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                //get the treatment price
                                //write query to get price
                                //$price = \App\Models\LabItem::find($get('lab_item_id'));
                                //update the placeholder field
                                $set('price', \App\Models\LabItem::find($get('labitem_id'))->price);                               // $set('price_max', $treatment->price_max);
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
                            ->label('Quantity')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        TextInput::make('price')
                            ->columnSpan(['xl' => 1, 'lg' => 2, 'md' => 2, 'sm' => 2])
                            ->label('Price')
                            ->numeric()->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->suffix('kyats')
                            ->default(0)
                            ->prefixIcon('heroicon-o-banknotes')
                            ->required(),
                        //         Placeholder::make('calculated_fee')
                        //             ->label('Calculated Fee')
                        //             ->content(function (Get $get): string {
                        //                 $price = $get('price');
                        //                 $quantity = $get('quantity');
                        //                 return number_format($price * $quantity) . ' kyats';
                        //             }),

                    ]),
                // TextInput::make('discount')
                //     ->placeholder('Discount')
                //     ->label('Discount')
                //     ->numeric()->mask(RawJs::make('$money($input)'))
                //     ->stripCharacters(',')
                //     ->columnSpanFull()
                //     ->default('0')
                //     ->suffix('kyats')
                //     ->prefixIcon('heroicon-o-currency-dollar')
                //     ->required(),
                Textarea::make('description')
                    ->placeholder('Remarks')
                    ->label('Descritpion')
                    ->columnSpanFull()
                    ->autosize()
                    ->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchase_date')
                ->date()
                ->label('Appointment Date'),
                TextColumn::make('total_expense')
                ->label('Total')
                ->suffix(' kyats'),
                ColumnGroup::make('Items', [
                    TextColumn::make('purchaselogitems.labitem.item.name')
                        ->label('Item name')
                        ->listWithLineBreaks()
                        ->bulleted(),
                        TextColumn::make('purchaselogitems.labitem.lab.name')
                        ->label('Lab name')
                        ->listWithLineBreaks()
                        ->bulleted()->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('purchaselogitems.quantity')
                        ->label('Quantity')
                        ->listWithLineBreaks()
                        ->suffix(' pieces')
                        ->bulleted(),
                    TextColumn::make('purchaselogitems.price')
                        ->label('Price')
                        ->listWithLineBreaks()
                        ->suffix(' kyats')
                        ->bulleted(),
                ]),
                TextColumn::make('description')
                    ->label('Remarks')->toggleable(isToggledHiddenByDefault: true),
               
            ])
            ->filters([
                //
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
            'index' => Pages\ListPurchaselogs::route('/'),
            'create' => Pages\CreatePurchaselog::route('/create'),
            'edit' => Pages\EditPurchaselog::route('/{record}/edit'),
        ];
    }
}
