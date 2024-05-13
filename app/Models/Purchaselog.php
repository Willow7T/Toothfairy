<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchaselog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','total','purchase_date','description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items() : HasMany
    {
        return $this->hasMany(PurchaselogItem::class);
    }
}
