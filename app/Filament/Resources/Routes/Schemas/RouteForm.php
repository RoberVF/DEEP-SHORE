<?php

namespace App\Filament\Resources\Routes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RouteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                Select::make('backpack_id')
                    ->relationship('backpack', 'name')
                    ->required(),
                TextInput::make('duration_days')->numeric()->required(),
                TextInput::make('location')->required(),
                DatePicker::make('date')->required(),
            ]);
    }
}
