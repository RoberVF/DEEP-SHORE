<?php

namespace App\Filament\Resources\Backpacks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BackpackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            Textarea::make('description'),
            Select::make('equipment')
                ->relationship('equipment', 'name')
                ->multiple()
                ->preload()
                ->required(),
        ]);
    }
}
