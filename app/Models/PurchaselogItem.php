<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaselogItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchaselog_id', 'item_id','quantity','price'
    ];
    

    public function purchaselog()
    {
        return $this->belongsTo(Purchaselog::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
