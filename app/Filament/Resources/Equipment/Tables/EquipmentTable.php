<?php

namespace App\Filament\Resources\Equipment\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('brand')->searchable(),
            TextColumn::make('weight_grams')->label('Weight (g)')->sortable(),
            TextColumn::make('category'),
            TextColumn::make('color'),
        ]);
    }
}
