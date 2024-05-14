<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabItem extends Model
{
    use HasFactory;

    protected $table = 'lab_items';
    protected $fillable = [
        'lab_id', 'item_id', 'price'
    ];
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
