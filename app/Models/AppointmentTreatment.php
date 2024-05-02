<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AppointmentTreatment extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'appointment_id', 'treatment_id', 'price','quantity'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}

