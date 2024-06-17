<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\AppointmentTreatment;

class AppointmentTreatmentObserver
{
    /**
     * Handle the AppointmentTreatment "created" event.
     *
     * @param  \App\Models\AppointmentTreatment  $appointmentTreatment
     * @return void
     */
    public function created(AppointmentTreatment $appointmentTreatment): void
    {
        // Get the associated appointment
        $appointment = $appointmentTreatment->appointment;

        // Calculate the total_fee
        $this->updateTotalFee($appointment);
    }

    /**
     * Handle the AppointmentTreatment "updated" event.
     */
    public function updated(AppointmentTreatment $appointmentTreatment): void
    {
        $appointment = $appointmentTreatment->appointment;

        $this->updateTotalFee($appointment);
    }

    /**
     * Handle the AppointmentTreatment "deleted" event.
     *
     * @param  \App\Models\AppointmentTreatment  $appointmentTreatment
     * @return void
     */
    public function deleted(AppointmentTreatment $appointmentTreatment)
    {
        // Get the associated appointment
        $appointment = $appointmentTreatment->appointment;

        // Calculate the total_fee
        $this->updateTotalFee($appointment);
    }

    /**
     * Handle the AppointmentTreatment "restored" event.
     */
    public function restored(AppointmentTreatment $appointmentTreatment): void
    {
        //
    }

    /**
     * Handle the AppointmentTreatment "force deleted" event.
     */
    public function forceDeleted(AppointmentTreatment $appointmentTreatment): void
    {
        //
    }
    /**
     * Calculate and update the total_fee for the appointment.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return void
     */
    protected function updateTotalFee(Appointment $appointment)
    {
        // Calculate the total fee price per piece * quantity
        $totalFee = $appointment->treatments->sum(function ($treatment) {
            return $treatment->price * $treatment->quantity;
        });

        $appointment->calculated_fee = $totalFee;
        $appointment->save();
    }
}
