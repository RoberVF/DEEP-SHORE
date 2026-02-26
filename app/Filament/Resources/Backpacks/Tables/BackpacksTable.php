<?php

namespace App\Filament\Resources\Backpacks\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Illuminate\Support\Collection;

class BackpacksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn($record) => $record->brand ?? 'No brand specified'),

                TextColumn::make('capacity_liters')
                    ->label('Volume')
                    ->suffix(' L')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('equipment_count')
                    ->counts('equipment')
                    ->label('Items')
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),

                TextColumn::make('total_weight')
                    ->label('Total Weight')
                    ->getStateUsing(fn($record) => ($record->equipment->sum('weight_grams') / 1000) . ' kg')
                    ->icon('heroicon-m-scale')
                    ->weight('bold')
                    ->color(function ($state, $record) {
                        $weight = (float) $state * 1000;
                        if (!$record->max_weight_grams) return 'success';
                        return $weight > $record->max_weight_grams ? 'danger' : 'success';
                    })
                    ->description(fn($record) => $record->max_weight_grams
                        ? 'Limit: ' . ($record->max_weight_grams / 1000) . ' kg'
                        : 'No limit set'),

                TextColumn::make('categories')
                    ->label('Content Type')
                    ->getStateUsing(function ($record) {
                        return $record->equipment->pluck('category')
                            ->unique()
                            ->map(fn($cat) => ucfirst($cat->value ?? $cat))
                            ->join(', ');
                    })
                    ->wrap()
                    ->size('xs')
                    ->color('gray'),

                TextColumn::make('value')
                    ->label('Kit Value')
                    ->getStateUsing(fn($record) => '€' . number_format($record->equipment->sum('price'), 2))
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('duplicate')
                    ->label('Clone Kit')
                    ->icon('heroicon-m-squares-plus')
                    ->color('gray')
                    ->action(function ($record) {
                        $newRecord = $record->replicate(['equipment_count']);
                        $newRecord->name = $record->name . ' (Copy)';
                        $newRecord->save();

                        $newRecord->equipment()->attach($record->equipment->pluck('id'));
                    })
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
