<?php

namespace App\Filament\Resources\DentistResource\Pages;

use App\Filament\Resources\DentistResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDentist extends ViewRecord
{
    protected static string $resource = DentistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->slideOver(),
        ];
    }
}
