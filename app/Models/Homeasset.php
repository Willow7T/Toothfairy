<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homeasset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'image',
        'image2',
        'h1',
        'h2',
        'p'
    ];
}
