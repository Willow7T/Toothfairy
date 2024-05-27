<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;


class LabItem extends Model
{
    use HasFactory;

    protected $table = 'lab_items';
    protected $fillable = [
        'lab_id', 'item_id', 'price'
    ];
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public static function searchItems(string $search): \Illuminate\Support\Collection
    {   
        $searchParts = explode(' +', $search);
        $itemSearch = strtolower($searchParts[0] ?? '');
        $labSearch = strtolower($searchParts[1] ?? '');

        
        return LabItem::query()
            ->whereHas('item', function ($query) use ($itemSearch) {
                $query->whereRaw('LOWER(name) LIKE ?', ["%{$itemSearch}%"]);
            })
            ->whereHas('lab', function ($query) use ($labSearch) {
                $query->whereRaw('LOWER(name) LIKE ?', ["%{$labSearch}%"]);
            })
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get()
            ->mapWithKeys(function ($labitem) {
                return [$labitem->id => "{$labitem->item->name} ({$labitem->lab->name} - {$labitem->price})"];
            });

    }
    public static function getForm():array
    {
    return [
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
                    ->relationship('lab', 'name')
                    ->createOptionForm(Lab::getForm())
                    ->editOptionForm(Lab::getForm())
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
    ];
    }
}
