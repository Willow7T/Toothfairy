<?php

namespace App\Livewire;

use App\Models\Treatment;
use Livewire\Component;

class LoadTreatments extends Component
{
    public function render()
    {   //get all treatments in random order
        // Get all treatments in random order
        $treatments = Treatment::inRandomOrder()->get();

        return view(
            'livewire.load-treatments',
            [
                'treatments' => $treatments
            ]
        );

        return view(
            'livewire.load-treatments',
            [
                'treatments' => $treatments
            ]
        );
    }
}
