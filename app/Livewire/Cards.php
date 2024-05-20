<?php

namespace App\Livewire;

use App\Models\Card;
use Livewire\Component;

class Cards extends Component
{
    public function render()
    {
        //grab all the cards from the database where the status is active and order by the sort order if the order is same sort with last updated
        $cards= Card::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();
            //dd($cards->first()->image);
        return view('livewire.cards', [
            'cards' => $cards
        ]);
    }
}
