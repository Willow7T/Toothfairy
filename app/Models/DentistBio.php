<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentistBio extends Model
{
    use HasFactory;
    protected $table = 'dentist_bio';

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'age',
        'qualification',
        'experience',
        'phone_no',
    ];
}
