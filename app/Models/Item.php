<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;


class Item extends Model
{
    use HasFactory;
    use SoftDeletes; 
    
    protected $fillable = ['name', 'description', 'price'];

    public function labs(): HasMany
    {
        return $this->hasMany(LabItem::class);
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
