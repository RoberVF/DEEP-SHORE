<?php

namespace App\Filament\Resources\Routes\Schemas;

use App\Enums\RouteStatus;
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
                TextInput::make('name')
                    ->required(),

                Select::make('backpack_id')
                    ->relationship('backpack', 'name')
                    ->required(),

                Select::make('status')
                    ->options(RouteStatus::class)
                    ->required(),

                TextInput::make('location')
                    ->required(),

                TextInput::make('coordinates')
                    ->placeholder('Lat, Long or MGRS'),

                TextInput::make('duration_days')
                    ->numeric()
                    ->required(),

                TextInput::make('estimated_kcal')
                    ->numeric()
                    ->suffix('kcal'),

                DatePicker::make('date')
                    ->required(),
            ]);
    }
}
