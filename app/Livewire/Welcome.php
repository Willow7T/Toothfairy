<?php

namespace App\Livewire;

use App\Models\About;
use App\Models\Homeasset;
use Livewire\Component;

class Welcome extends Component
{
    public function render()
    {
        $homeasset = Homeasset::where('is_active', 1)->inRandomOrder()->first();

        //get only 1 content from about us table where type is paragraph and ordered by lasted update
        $about_content = About::where('type', 'paragraph')->latest()->first();
        //get only 5 links and icon from about us table where type is social and ordered by latest
        $social_links = About::where('type', 'social')->latest()->take(5)->get();
        //get only 1 image from about us table where type is image and ordered by lasted update
        $about_image = About::where('type', 'image')->latest()->first();


        return view(
            'livewire.welcome',
            [
                'homeasset' => $homeasset,
                'about_content' => $about_content,
                'about_image' => $about_image,
                'social_links' => $social_links,
            ]
        );
    }
}
