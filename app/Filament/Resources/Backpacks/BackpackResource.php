<?php

namespace App\Filament\Resources\Backpacks;

use App\Filament\Resources\Backpacks\Pages\CreateBackpack;
use App\Filament\Resources\Backpacks\Pages\EditBackpack;
use App\Filament\Resources\Backpacks\Pages\ListBackpacks;
use App\Filament\Resources\Backpacks\Schemas\BackpackForm;
use App\Filament\Resources\Backpacks\Tables\BackpacksTable;
use App\Models\Backpack;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BackpackResource extends Resource
{
    protected static ?string $model = Backpack::class;

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    public static function form(Schema $schema): Schema
    {
        return BackpackForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BackpacksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBackpacks::route('/'),
            'create' => CreateBackpack::route('/create'),
            'edit' => EditBackpack::route('/{record}/edit'),
        ];
    }
}
