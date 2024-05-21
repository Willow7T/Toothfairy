<?php

namespace App\Filament\Resources\HomeassetResource\Pages;

use App\Filament\Resources\HomeassetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeasset extends EditRecord
{
    protected static string $resource = HomeassetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
