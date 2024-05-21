<?php

namespace App\Livewire;

use App\Models\Homeasset;
use Livewire\Component;

class CardHome extends Component
{
    public function render()
    {
        //get randomly get one of the home assests which is active 
        $homeasset = Homeasset::where('is_active', 1)->inRandomOrder()->first();
        return view('livewire.card-home',
            [
                'homeasset' => $homeasset
            ]
    );
    }
}
