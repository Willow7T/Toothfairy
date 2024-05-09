<?php

namespace App\Filament\Resources\PatientsResource\Pages;

use App\Filament\Resources\PatientsResource;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists;
use Filament\Resources\Pages\ViewRecord;

class ViewPatients extends ViewRecord
{
    protected static string $resource = PatientsResource::class;
 
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->slideOver(),
        ];
    }
 
  
}

