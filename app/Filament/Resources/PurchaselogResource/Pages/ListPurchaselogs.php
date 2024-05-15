<?php

namespace App\Filament\Resources\PurchaselogResource\Pages;

use App\Filament\Resources\PurchaselogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaselogs extends ListRecords
{
    protected static string $resource = PurchaselogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
