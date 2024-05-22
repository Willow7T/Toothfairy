<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Facades\Storage;

class CardObserver
{
    /**
     * Handle the Card "created" event.
     */
    public function created(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "updated" event.
     */
    public function updated(Card $card): void
    {
        if ($card->isDirty('image')) {
            // Get the original file
            $original = $card->getOriginal('image');
            // If the original file is not null, delete it
            if ($original && Storage::exists('public/' . $original)) {
                Storage::delete('public/' . $original);
            }
        }
    }

    /**
     * Handle the Card "deleted" event.
     */
    public function deleted(Card $card): void
    {
        if ($card->image) {
            Storage::delete('public/'.$card->image);
        }
    }

    /**
     * Handle the Card "restored" event.
     */
    public function restored(Card $card): void
    {
        //
    }

    /**
     * Handle the Card "force deleted" event.
     */
    public function forceDeleted(Card $card): void
    {
        //
    }
}
