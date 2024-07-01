<?php

namespace App\Filament\Resources\PatientsResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Resources\Pages\ViewRecord;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->slideOver(),
        ];
    }
}
