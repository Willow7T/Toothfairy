<?php

namespace App\Filament\Resources\PurchaselogResource\Pages;

use App\Filament\Resources\PurchaselogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPurchaselog extends ViewRecord
{
    protected static string $resource = PurchaselogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->slideOver(),
        ];
    }
}
