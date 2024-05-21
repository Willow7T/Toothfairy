<?php

namespace App\Filament\Resources\HomeassetResource\Pages;

use App\Filament\Resources\HomeassetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeassets extends ListRecords
{
    protected static string $resource = HomeassetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
