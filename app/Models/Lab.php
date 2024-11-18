<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lab extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'phone_no', 'email', 'website'];

    // public function items(): HasMany
    // {
    //     return $this->hasMany(LabItem::class);
    // }
    public static function getForm():array
    {
    return [
        TextInput::make('name')
            ->label('Lab name')
            ->required()
            ->maxLength(30),
        TextInput::make('email')
            ->label('Email')
            ->email()
            ->unique(ignoreRecord: true)
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
    ];
    }
}
