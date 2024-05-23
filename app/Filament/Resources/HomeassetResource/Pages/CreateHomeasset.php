<?php

namespace App\Filament\Resources\HomeassetResource\Pages;

use App\Filament\Resources\HomeassetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomeasset extends CreateRecord
{
    protected static string $resource = HomeassetResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
