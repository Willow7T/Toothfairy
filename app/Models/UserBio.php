<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBio extends Model
{
    use HasFactory, SoftDeletes;

    // Specify the table name
    protected $table = 'user_bio';

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add the attributes you want to allow mass assignment
    protected $fillable = [
        'birthday',
        'age',
        'sex',
        'medical_info',
        'phone_no',
        'address',
    ];
}
