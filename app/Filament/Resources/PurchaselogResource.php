<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaselogResource\Pages;
use App\Filament\Resources\PurchaselogResource\RelationManagers;
use App\Models\LabItem;
use App\Models\Item;
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
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

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
                    ]),

                Repeater::make('purchaselog_id')
                    ->label('Items')
                    ->relationship('purchaselogitems')
                    ->columnSpan(4)
                    ->addActionLabel('Add Items')
                    ->grid(2)
                    ->hint(new HtmlString('
                    <p>Search with item name and lab name. To search with lab name use<span class="text-primary-400">" +"</span>before the typing the lab name.</p>
                    <p>Example: type <span>"Denture +2"</span> to search Denture from Lab 2</p>
                    <p>Keys: <kbd class="min-h-[30px] inline-flex justify-center items-center py-1 px-1.5 bg-white border border-gray-200 font-fira text-sm text-primary-500 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,0.08)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:shadow-[0px_2px_0px_0px_rgba(255,255,255,0.1)]"
                    >space</kbd><span class="text-primary-400"> + </span>
                    <kbd class="min-h-[30px] inline-flex justify-center items-center py-1 px-1.5 bg-white border border-gray-200 font-fira text-sm text-primary-500 rounded-md shadow-[0px_2px_0px_0px_rgba(0,0,0,0.08)] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:shadow-[0px_2px_0px_0px_rgba(255,255,255,0.1)]"
                    >+</kbd>
                    </p>
                    '))
                    ->defaultItems(2)
                    ->schema([
                        Select::make('labitem_id')
                            ->label('Item')
                            ->relationship('labitem', 'id')
                            ->live(onBlur: true)
                            ->searchable()
                            //orderedby last update
                            ->options(LabItem::orderBy('updated_at', 'desc')->get()->mapWithKeys(function ($labItem) {
                                return [$labItem->id => "{$labItem->item->name} ({$labItem->lab->name} - {$labItem->price})"];
                            }))
                            ->getSearchResultsUsing(fn (string $search): array =>
                            LabItem::searchItems($search)->toArray())

                            ->loadingMessage('Loading items...')
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
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
                    ->label('Purchase Date'),
                TextColumn::make('total_expense')
                    ->label('Total')
                    ->suffix(' kyats'),
                ColumnGroup::make('Items', [
                    TextColumn::make('purchaselogitems.labitem.item.name')
                        ->label('Item name')
                        ->searchable()
                        ->listWithLineBreaks()
                        ->bulleted(),
                    TextColumn::make('purchaselogitems.labitem.lab.name')
                        ->label('Lab name')
                        ->searchable()
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
                        ->summarize(Sum::make()->money(''))
                        ->suffix(' kyats')
                        ->bulleted(),
                ]),
                TextColumn::make('description')
                    ->label('Remarks')->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('purchase_date')
                    ->form([
                        Forms\Components\DatePicker::make('purchase_date_from')
                            ->native(false),
                        Forms\Components\DatePicker::make('purchase_date_until')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['purchase_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('purchase_date', '>=', $date),
                            )
                            ->when(
                                $data['purchase_date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('purchase_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    //->slideOver(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'view' => Pages\ViewPurchaselog::route('/{record}'),
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
