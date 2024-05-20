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
    }

    /**
     * Handle the Treatment "deleted" event.
     */
    public function deleted(Treatment $treatment): void
    {
        // Delete the edufile
        if ($treatment->edufile) {
            Storage::delete($treatment->edufile);
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
