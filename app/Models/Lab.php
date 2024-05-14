<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lab extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'phone_no', 'email', 'website'];

    // public function items(): HasMany
    // {
    //     return $this->hasMany(LabItem::class);
    // }
}
