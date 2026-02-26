<?php

namespace App\Filament\Resources\Equipment\Schemas;

use App\Enums\Condition;
use App\Enums\EquipmentCategory;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Visual & Identity')
                ->description('Identify your gear with images and brands')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->placeholder('Ex: Mil-Tec Assault Pack'),
                    TextInput::make('brand')
                        ->placeholder('Ex: Mil-Tec, Cressi, Jetboil'),
                    FileUpload::make('image_path')
                        ->image()
                        ->disk('supabase')
                        ->directory('items')
                        ->visibility('public')
                        ->maxSize(1024)
                        ->imageEditor()
                        ->imageResizeTargetWidth('800')
                        ->imageResizeTargetHeight('800')
                        ->imageResizeMode('cover')
                        ->loadingIndicatorPosition('left')
                        ->removeUploadedFileButtonPosition('right')
                        ->uploadButtonPosition('left'),
                ]),

            Section::make('Technical Specifications')
                ->columns(3)
                ->schema([
                    Select::make('category')
                        ->options(EquipmentCategory::class)
                        ->required()
                        ->native(false),
                    TextInput::make('weight_grams')
                        ->numeric()
                        ->suffix('g')
                        ->required()
                        ->step(1),
                    ColorPicker::make('color'),
                ]),

            Section::make('Operational Status')
                ->columns(3)
                ->schema([
                    Select::make('condition')
                        ->options(Condition::class)
                        ->required()
                        ->native(false),
                    DatePicker::make('last_maintained_at'),
                    TextInput::make('price')
                        ->numeric()
                        ->prefix('€'),
                    Toggle::make('is_essential')
                        ->label('High Priority / Essential')
                        ->onIcon('heroicon-m-bolt')
                        ->offIcon('heroicon-m-minus')
                        ->columnSpanFull(),
                ]),

            Section::make('Detailed Notes')
                ->schema([
                    RichEditor::make('technical_notes')
                        ->placeholder('Add specific specs, serial numbers or maintenance tips...'),
                ]),
        ]);
    }
}
