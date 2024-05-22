<?php

namespace App\Observers;

use App\Models\About;
use Illuminate\Support\Facades\Storage;

class AboutObserver
{
    /**
     * Handle the About "created" event.
     */
    public function created(About $about): void
    {
        //
    }

    /**
     * Handle the About "updated" event.
     */
    public function updated(About $about): void
    {
        if ($about->isDirty('image')) {
            // Get the original file
            $original = $about->getOriginal('image');
            // If the original file is not null, delete it
            if ($original && Storage::exists('public/' . $original)) {
                Storage::delete('public/' . $original);
            }
        }
    }

    /**
     * Handle the About "deleted" event.
     */
    public function deleted(About $about): void
    {
        if ($about->image) {
            Storage::delete('public/'.$about->image);
        }
    }

    /**
     * Handle the About "restored" event.
     */
    public function restored(About $about): void
    {
        //
    }

    /**
     * Handle the About "force deleted" event.
     */
    public function forceDeleted(About $about): void
    {
        //
    }
}
