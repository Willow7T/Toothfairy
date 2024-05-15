<?php

namespace App\Observers;

use App\Models\Purchaselog;
use App\Models\PurchaselogItem;

class PurchaselogObserver
{
    /**
     * Handle the PurchaselogItem "created" event.
     */
    public function created(PurchaselogItem $purchaselogItem): void
    {
           // Get the associated purchaselog
           $purchaselog = $purchaselogItem->purchaselog;

           // Calculate the total_fee
           $this->updateTotalFee($purchaselog);
    }

    /**
     * Handle the PurchaselogItem "updated" event.
     */
    public function updated(PurchaselogItem $purchaselogItem): void
    {
        $purchaselog = $purchaselogItem->purchaselog;

           // Calculate the total_fee
           $this->updateTotalFee($purchaselog);
    }

    /**
     * Handle the PurchaselogItem "deleted" event.
     */
    public function deleted(PurchaselogItem $purchaselogItem): void
    {
        $purchaselog = $purchaselogItem->purchaselog;

        // Calculate the total_fee
        $this->updateTotalFee($purchaselog);
    }

    /**
     * Handle the PurchaselogItem "restored" event.
     */
    public function restored(PurchaselogItem $purchaselogItem): void
    {
        //
    }

    /**
     * Handle the PurchaselogItem "force deleted" event.
     */
    public function forceDeleted(PurchaselogItem $purchaselogItem): void
    {
        //
    }

    protected function updateTotalFee(Purchaselog $purchaselog)
    {
        // Calculate the total fee price per piece * quantity
        $totalFee = $purchaselog->purchaselogitems->sum(function ($purchaselogitem) {
            return $purchaselogitem->price * $purchaselogitem->quantity;
        });

        //dd($totalFee);
        $purchaselog->total_expense = $totalFee;
     
        $purchaselog->save();
    }
}
