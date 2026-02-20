<?php

namespace App\Filament\Resources\Backpacks\Pages;

use App\Filament\Resources\Backpacks\BackpackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBackpacks extends ListRecords
{
    protected static string $resource = BackpackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
