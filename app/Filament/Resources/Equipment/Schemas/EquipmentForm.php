<?php

namespace App\Filament\Resources\Equipment\Schemas;

use App\Enums\Condition;
use App\Enums\EquipmentCategory;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Core Specifications')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('brand'),
                    Select::make('category')
                        ->options(EquipmentCategory::class)
                        ->required(),
                    TextInput::make('weight_grams')
                        ->numeric()
                        ->suffix('g')
                        ->required(),
                ]),
            Section::make('Status & Value')
                ->columns(3)
                ->schema([
                    Select::make('condition')
                        ->options(Condition::class)
                        ->required(),
                    ColorPicker::make('color'),
                    TextInput::make('price')
                        ->numeric()
                        ->prefix('€'),
                    DatePicker::make('last_maintenance_at'),
                ]),
        ]);
    }
}
