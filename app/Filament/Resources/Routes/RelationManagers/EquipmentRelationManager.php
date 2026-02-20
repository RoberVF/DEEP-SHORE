<?php

namespace App\Filament\Resources\Routes\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Schema;

class EquipmentRelationManager extends RelationManager
{
    protected static string $relationship = 'equipment';

    protected static ?string $recordTitleAttribute = 'name';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Item Name'),
                TextColumn::make('brand')->label('Brand'),
                TextColumn::make('weight_grams')->label('Weight (g)'),
                TextColumn::make('color')->label('Color'),
            ]);
    }
}
