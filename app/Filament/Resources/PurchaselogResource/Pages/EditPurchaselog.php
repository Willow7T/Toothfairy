<?php

namespace App\Filament\Resources\PurchaselogResource\Pages;

use App\Filament\Resources\PurchaselogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaselog extends EditRecord
{
    protected static string $resource = PurchaselogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
