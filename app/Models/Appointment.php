<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'patient_id', 'dentist_id', 'appointment_date', 'status', 'calculated_fee', 'discount', 'discount_percentage', 'total_fee', 'description'
    ];

    protected static function boot()
    {
        parent::boot();

        // Hook into the creating and updating events to calculate total_fee
        static::creating(function ($appointment) {
            $totalFee = $appointment->calculated_fee;
            $dicount = $totalFee * ($appointment->discount_percentage / 100);
            $discount = $dicount + $appointment->discount;
            $appointment->total_fee = $appointment->calculated_fee - $discount;
        });

        static::updating(function ($appointment) {
            $totalFee = $appointment->calculated_fee;
            $dicount = $totalFee * ($appointment->discount_percentage / 100);
            $discount = $dicount + $appointment->discount;
            $appointment->total_fee = $appointment->calculated_fee - $discount;
        });
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id')->where('role_id', 3);
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id')->where('role_id', 2);
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(AppointmentTreatment::class)
            //->withPivot('price')
        ;
    }
}
