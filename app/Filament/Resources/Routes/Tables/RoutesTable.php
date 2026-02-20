<?php

namespace App\Filament\Resources\Routes\Tables;

use App\Enums\RouteStatus;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class RoutesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('date')
                    ->date()
                    ->sortable(),

                TextColumn::make('location')
                    ->searchable()
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray'),

                TextColumn::make('backpack.name')
                    ->label('Loadout')
                    ->description(fn($record) => $record->backpack->equipment->count() . ' items included')
                    ->sortable(),

                TextColumn::make('total_weight')
                    ->label('Total Weight')
                    ->getStateUsing(fn($record) => ($record->backpack->equipment->sum('weight_grams') / 1000) . ' kg')
                    ->icon('heroicon-m-scale')
                    ->color(fn($state) => (float)$state > 18 ? 'danger' : 'success')
                    ->sortable(),

                TextColumn::make('estimated_kcal')
                    ->label('Energy Cost')
                    ->suffix(' kcal')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('duration_days')
                    ->label('Ops Duration')
                    ->suffix(' days')
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RouteStatus::class),

                SelectFilter::make('backpack_id')
                    ->label('By Backpack')
                    ->relationship('backpack', 'name'),
            ])
            ->actions([
                ActionsEditAction::make(),
                ActionsAction::make('open_maps')
                    ->label('GPS')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('info')
                    ->url(fn($record) => "https://www.google.com/maps/search/?api=1&query={$record->coordinates}")
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->coordinates)),
            ])
            ->bulkActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make(),
                ]),
            ]);
    }
}
