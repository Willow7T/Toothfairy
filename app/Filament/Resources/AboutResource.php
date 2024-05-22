<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Filament\Resources\AboutResource\RelationManagers;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    //modaltitle
    protected static ?string $pluralModelLabel = 'About Us';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name of the About')
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->live()
                    ->options([
                        'social' => 'Social',
                        'paragraph' => 'Paragraph',
                        'image' => 'Image',
                    ])
                    ->default('social')
                    ->required(),
                RichEditor::make('content')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'redo',
                        'undo',
                        'h2',
                        'h3',
                        'blockquote',
                    ])
                    ->columnSpanFull()
                    ->hint('U can use')
                    ->hidden(fn (Get $get): bool => !($get('type') === 'paragraph' ? true : false)),
                FileUpload::make('image')
                    ->image()
                    ->directory('AboutUs')
                    ->required()
                    ->imageEditor()
                    ->downloadable()
                    ->maxSize(30000)
                    ->columnSpanFull()
                    ->previewable()
                    ->hidden(fn (Get $get): bool => !($get('type') === 'image' ? true : false)),
                TextInput::make('link')
                    ->label('Links')
                    ->prefix('https://')
                    ->suffixIcon('heroicon-o-globe-alt')
                    ->url()
                    ->required()
                    ->hint(new HtmlString('
                    <p>Please use full URL for links!</p>
                    <p>Example Social Link: <span class="text-primary-400">https://x.com/Wfdskf</span></p>
                    <p>Example Website: <span class="text-primary-400">https://laravel.com</span></p>
                    '))
                    ->hidden(fn (Get $get): bool => !($get('type') === 'social' ? true : false)),
                TextInput::make('icon')
                    ->label('Social Icon')
                    // ->hint('Please use Fontawesome Brands icons from bladeuitkit docs'. new HtmlString('<a href="/documentation">Documentation</a>'))
                    ->hint(new HtmlString('
                    <p>Please use Fontawesome Brands icons from <span><a class="text-primary-400" href="https://blade-ui-kit.com/blade-icons?set=7#search"> Blade UI Kit Documentation</a></span>
                    </p>
                    <p>Example: <span class="text-primary-400">fab-facebook-f</span></p>
                    '))
                    ->required()
                    ->hidden(fn (Get $get): bool => !($get('type') === 'social' ? true : false)),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                TextColumn::make('content')
                    ->html()
                    ->hidden()
                    ->wrap(),
            ])
            ->filters([
                //filter with type

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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            // 'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
