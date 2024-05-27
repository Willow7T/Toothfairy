<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_register',
        'price_min',
        'price_max',
        'edufile',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public static function getForm():array
    {
    return [
        TextInput::make('name')
            ->required()
            ->maxLength(100),
        Textarea::make('description')
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
        ];
    }
}
