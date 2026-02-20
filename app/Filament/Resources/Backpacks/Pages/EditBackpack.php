<?php

namespace App\Filament\Resources\Backpacks\Pages;

use App\Filament\Resources\Backpacks\BackpackResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBackpack extends EditRecord
{
    protected static string $resource = BackpackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
