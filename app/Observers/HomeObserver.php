<?php

namespace App\Observers;

use App\Models\Homeasset;
use Illuminate\Support\Facades\Storage;

class HomeObserver
{
    /**
     * Handle the Homeasset "created" event.
     */
    public function created(Homeasset $homeasset): void
    {
        //
    }

    /**
     * Handle the Homeasset "updated" event.
     */
    public function updated(Homeasset $homeasset): void
    {
        if ($homeasset->isDirty('image')) {
            // Get the original file
            $original = $homeasset->getOriginal('image');
            // If the original file is not null, delete it
            if ($original && Storage::exists('public/' . $original)) {
                Storage::delete('public/' . $original);
            }
        }
        if ($homeasset->isDirty('image2')) {
            // Get the original file
            $original = $homeasset->getOriginal('image2');
            // If the original file is not null, delete it
            if ($original && Storage::exists('public/' . $original)) {
                Storage::delete('public/' . $original);
            }
        }
    }

    /**
     * Handle the Homeasset "deleted" event.
     */
    public function deleted(Homeasset $homeasset): void
    {
        if ($homeasset->image ) {
            Storage::delete('public/'.$homeasset->image);
        }
        if ($homeasset->image2 ) {
            Storage::delete('public/'.$homeasset->image2);
        }
    }

    /**
     * Handle the Homeasset "restored" event.
     */
    public function restored(Homeasset $homeasset): void
    {
        //
    }

    /**
     * Handle the Homeasset "force deleted" event.
     */
    public function forceDeleted(Homeasset $homeasset): void
    {
        //
    }
}
