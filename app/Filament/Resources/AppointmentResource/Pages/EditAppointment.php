<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\ViewAction::make(),
            Actions\Action::make('PDF')
            ->label('PDF Print')
            ->icon('fluentui-document-pdf-32')
            ->action(function ($record) {
                // Get record in array
                $appointment = Appointment::find($record->id);
                $patient = $appointment->patient;
                $treatments = $appointment->treatments;
                $formattedDate = date('F j, Y', strtotime($appointment->appointment_date));


                $data = compact('treatments', 'patient','appointment', 'formattedDate');
                $pdf = Pdf::loadView('printables.appointmentprint', $data);

                // Save the PDF to a temporary file
                $tempFile = tempnam(sys_get_temp_dir(), 'appointment') . '.pdf';
                file_put_contents($tempFile, $pdf->output());
                // Return a URL to the temporary file for direct print
                return response()->redirectTo(url('/temp/' . basename($tempFile)));

                //download as pdf
                // return response()->streamDownload(function () use ($pdf) {
                //     echo $pdf->stream();
                //     }, 'appointment.pdf');
            }),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
