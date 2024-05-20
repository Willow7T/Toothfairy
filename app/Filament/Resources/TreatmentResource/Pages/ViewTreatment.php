<?php

namespace App\Filament\Resources\TreatmentResource\Pages;

use App\Filament\Resources\TreatmentResource;
use App\Models\Treatment;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ViewTreatment extends ViewRecord
{
    protected static string $resource = TreatmentResource::class;

   
    //title treatment name
    public function getTitle(): string |Htmlable
    {
       $getTitle = function (Model $record): string | Htmlable {
        return $record->name;
    };

    // Call the closure function and return its result
    return $getTitle($this->record);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->slideOver()
            ->icon('heroicon-o-pencil')
            ->hidden(ViewTreatment::hiddenfrompatients()),
        ];
    }
    protected static function hiddenfrompatients(): bool
    {
        // Get the current authenticated user
        $user = auth()->user();

        // Hide the fieldset if the user's role is 'patient'
        return $user->role->name === 'patient';
    }
    
}
