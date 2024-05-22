<?php

namespace App\Observers;

use App\Models\Treatment;
use Illuminate\Support\Facades\Storage;

class TreatmentObserver
{
    /**
     * Handle the Treatment "created" event.
     */
    public function created(Treatment $treatment): void
    {
        //
    }

    /**
     * Handle the Treatment "updated" event.
     */
    public function updated(Treatment $treatment): void
    {
        // If the edufile has been changed
        if ($treatment->isDirty('edufile')) {
            // Get the original edufile
            $originalEdufile = $treatment->getOriginal('edufile');
            //dd($originalEdufile);
            // If the original edufile is not null, delete it
            if ($originalEdufile && Storage::exists('public/'.$originalEdufile)) {
                Storage::delete('public/'.$originalEdufile);
            }
        }
        if ($treatment->isDirty('image')) {
            // Get the original file
            $original = $treatment->getOriginal('image');
            // If the original file is not null, delete it
            if ($original && Storage::exists('public/' . $original)) {
                Storage::delete('public/' . $original);
            }
        }
    }

    /**
     * Handle the Treatment "deleted" event.
     */
    public function deleted(Treatment $treatment): void
    {
        // Delete the edufile
        if ($treatment->edufile) {
            Storage::delete('public/'.$treatment->edufile);
        }
        if ($treatment->image) {
            Storage::delete('public/'.$treatment->image);
        }
    }

    /**
     * Handle the Treatment "restored" event.
     */
    public function restored(Treatment $treatment): void
    {
        //
    }

    /**
     * Handle the Treatment "force deleted" event.
     */
    public function forceDeleted(Treatment $treatment): void
    {
        //
    }
}
