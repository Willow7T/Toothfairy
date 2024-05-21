<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class FAQs extends Page
{

    protected static ?string $title = 'Frequently Asked Questions';

    //slug
    public static function getSlug(): string
    {
        return 'faqs';
    }



    protected static string $view = 'filament.pages.faqs';

}
