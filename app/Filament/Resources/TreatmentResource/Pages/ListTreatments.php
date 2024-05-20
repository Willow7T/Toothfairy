<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use App\Filament\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTreatments extends ListRecords
{
    protected static string $resource = TreatmentResource::class;


    protected function getHeaderActions(): array
    {
        return [
            //only return this if user is admin
            Actions\CreateAction::make()
                ->hidden(function () {
                    // Get the current authenticated user
                    $user = auth()->user();

                    // Hide the fieldset if the user's role is 'patient'
                    return $user->role->name === 'patient';
                })
        ];
    }
}
