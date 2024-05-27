<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use App\Filament\Resources\TreatmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTreatment extends CreateRecord
{
    protected static string $resource = TreatmentResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        $user = auth()->user();
       // dd($user->role->name);  
        // Hide the fieldset if the user's role is 'patient'
        return !($user->role->name === 'patient');    
    }
   
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }


}
