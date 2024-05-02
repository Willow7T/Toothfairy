<?php

namespace App\Filament\Resources\DentistResource\Pages;

use App\Filament\Resources\DentistResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDentist extends CreateRecord
{
    protected static string $resource = DentistResource::class;

    protected function mutateFormDataAfterCreate(array $data): array
    {
        $data['role_id'] = 2;
        $data['password'] = 'password';
        return $data;
    }
  
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
