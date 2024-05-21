<?php

namespace App\Filament\App\Resources\AppointmentResource\Pages;
use App\Filament\App\Resources\AppointmentResource\Pages;

use App\Filament\App\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['patient_id'] = auth()->user()->id;
      
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
// Repeater::make('treatments')
// ->relationship('treatments')
// ->columnSpanFull()
// ->disabled()
// ->schema([
//     Select::make('treatment_id')
//         ->label('Treatment')
//         ->relationship('treatment', 'name')
//         ->default(1)
//         ->disabled()
//         //orderedby last update
//         ->options(Treatment::orderBy('updated_at', 'desc')->get()->pluck('name', 'id'))
//         ->loadingMessage('Loading treatments...')
//         ->required(),
// ])
