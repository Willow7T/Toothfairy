<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Gallery extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    //change title
    protected static ?string $title = 'Gallery';

    protected static string $view = 'filament.pages.gallery';


}
