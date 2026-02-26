<?php

namespace App\Filament\Resources\Backpacks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BackpackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('General Information')
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('brand'),
                    TextInput::make('capacity_liters')
                        ->numeric()
                        ->suffix('L'),
                    TextInput::make('max_weight_grams')
                        ->label('Max Load Target')
                        ->numeric()
                        ->suffix('g')
                        ->helperText('Visual alert if content exceeds this weight'),
                    Textarea::make('description')
                        ->columnSpanFull(),
                ]),

            Section::make('Gear Inventory')
                ->description('Select the items that form this tactical kit')
                ->schema([
                    Select::make('equipment')
                        ->relationship('equipment', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->label('Included Gear')
                        ->required(),
                ]),
        ]);
    }
}
