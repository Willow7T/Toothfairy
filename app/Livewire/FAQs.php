<?php

namespace App\Livewire;

use App\Models\Faq;
use Livewire\Component;

class FAQs extends Component
{
    public function render()
    {
        //grab all the faqs from the database where the status is active and order by the sort order if the order is same sort with last updated
        $faqs= Faq::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('livewire.faqs', [
            'faqs' => $faqs
        ]);
    }
}
