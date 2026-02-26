<?php

namespace App\Filament\Resources\Equipment\Tables;

use App\Enums\Condition;
use App\Enums\EquipmentCategory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Support\Enums\FontWeight;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('')
                    ->circular()
                    ->disk('public'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn($record) => $record->brand),

                TextColumn::make('category')
                    ->badge()
                    ->sortable(),

                TextColumn::make('condition')
                    ->badge()
                    ->sortable(),

                TextColumn::make('weight_grams')
                    ->label('Weight')
                    ->suffix(' g')
                    ->sortable()
                    ->summarize(\Filament\Tables\Columns\Summarizers\Sum::make()
                        ->label('Total Weight')
                        ->formatStateUsing(fn($state) => ($state / 1000) . ' kg')),

                ColorColumn::make('color')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_essential')
                    ->label('Essential')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-x-mark')
                    ->alignCenter(),

                TextColumn::make('price')
                    ->money('EUR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(EquipmentCategory::class),
                SelectFilter::make('condition')
                    ->options(Condition::class),
                \Filament\Tables\Filters\TernaryFilter::make('is_essential'),
            ])
            ->actions([
                Action::make('duplicate')
                    ->label('Clone')
                    ->icon('heroicon-m-squares-plus')
                    ->color('gray')
                    ->action(function ($record) {
                        $newRecord = $record->replicate();
                        $newRecord->name = $record->name . ' (Copy)';
                        $newRecord->save();
                    }),

                ViewAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
