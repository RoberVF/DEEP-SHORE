<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;

class EquipmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('header_tactical')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->content(fn($record) => new HtmlString("
                        <div class='flex flex-col md:flex-row md:items-center justify-between border-b-4 border-gray-900 pb-4 mb-6'>
                            <div>
                                <div class='flex items-center gap-3 mb-2'>
                                    <span class='px-2 py-0.5 bg-black text-[10px] font-black text-white uppercase tracking-[0.3em]'>Asset_Verified</span>
                                    <span class='text-[10px] font-mono text-gray-400 font-bold tracking-widest'>#DS-" . str_pad($record->id, 6, '0', STR_PAD_LEFT) . "</span>
                                </div>
                                <h2 class='text-5xl font-black tracking-tighter text-gray-900 uppercase leading-none'>{$record->name}</h2>
                                <p class='text-sm font-mono text-primary-600 font-black mt-2 tracking-widest'>" . ($record->brand ?? 'GENERAL_ISSUE_SPEC') . "</p>
                            </div>
                            <div class='mt-4 md:mt-0'>
                                <div class='border-4 border-gray-900 p-3 bg-white shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]'>
                                    <span class='text-[10px] font-black text-gray-400 block uppercase tracking-tighter mb-1'>Sync_Status</span>
                                    <span class='text-lg font-black text-gray-900 uppercase tracking-tighter leading-none'>Operational_Ready</span>
                                </div>
                            </div>
                        </div>
                    ")),

                Grid::make(2)->schema([
                    Section::make('Asset Visualization')
                        ->columnSpan(6)
                        ->schema([
                            Placeholder::make('image_render')
                                ->hiddenLabel()
                                ->content(function ($record) {
                                    if (!$record->image_path) {
                                        return new HtmlString("<div class='w-full aspect-[4/5] bg-gray-100 border-4 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 font-black text-[10px] uppercase p-10 text-center'>// Error: No_Visual_Source_Found</div>");
                                    }
                                    $url = Storage::disk('supabase')->url($record->image_path);
                                    return new HtmlString("
                                        <div class='relative border-4 border-gray-900 shadow-[12px_12px_0px_0px_rgba(0,0,0,0.05)] overflow-hidden bg-gray-900'>
                                            <img src='{$url}' class='w-full h-auto object-cover' />
                                            <div class='absolute inset-0 border-[16px] border-white/5 pointer-events-none'></div>
                                            <div class='absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/80 to-transparent'>
                                                <span class='text-[9px] font-mono text-white font-bold tracking-[0.2em]'>LIVE_SCAN_ACTIVE</span>
                                            </div>
                                        </div>
                                    ");
                                }),
                        ]),

                    Section::make('Field Specifications')
                        ->columnSpan(6)
                        ->schema([
                            Grid::make(2)->schema([
                                Placeholder::make('w')->hiddenLabel()->content(fn($record) => self::getTacticalCard('Mass', "{$record->weight_grams} g", 'amber')),
                                Placeholder::make('v')->hiddenLabel()->content(fn($record) => self::getTacticalCard('Value', $record->price ? "€" . number_format($record->price, 2) : 'N/A', 'emerald')),
                                Placeholder::make('c')->hiddenLabel()->content(fn($record) => self::getTacticalCard('Class', $record->category->value ?? $record->category, 'blue')),
                                Placeholder::make('s')->hiddenLabel()->content(function ($record) {
                                    $color = method_exists($record->condition, 'getColor') ? $record->condition->getColor() : 'gray';
                                    return self::getTacticalCard('Health', $record->condition->value ?? $record->condition, $color);
                                }),
                            ]),

                            // Barra de progreso de estado "Health"
                            Placeholder::make('health_bar')
                                ->hiddenLabel()
                                ->content(new HtmlString("
                                    <div class='mt-6 pt-6 border-t border-gray-100'>
                                        <div class='flex justify-between items-end mb-2'>
                                            <span class='text-[10px] font-black text-gray-400 uppercase tracking-widest'>Asset_Integrity_Index</span>
                                            <span class='text-sm font-black text-gray-900 font-mono'>92%</span>
                                        </div>
                                        <div class='h-4 bg-gray-100 border-2 border-gray-900 p-0.5 overflow-hidden'>
                                            <div class='h-full bg-emerald-500 w-[92%] shadow-[inset_0_2px_4px_rgba(0,0,0,0.1)] animate-pulse'></div>
                                        </div>
                                    </div>
                                ")),
                        ]),
                ]),

                // --- NIVEL 3: TERMINAL DE INTELIGENCIA (FULL ANCHO) ---
                Section::make('Tactical Log & Field Intelligence')
                    ->columnSpanFull()
                    ->schema([
                        Placeholder::make('terminal_render')
                            ->hiddenLabel()
                            ->content(fn($record) => new HtmlString("
                                <div class='bg-slate-950 rounded-lg p-8 font-mono text-sm shadow-2xl relative overflow-hidden border-l-[12px] border-emerald-900'>
                                    <div class='absolute top-0 right-0 p-4 text-[10px] text-emerald-900 font-black opacity-30'>DEEP_SHORE_OS_v4.1</div>
                                    <div class='flex gap-6 mb-6 text-[10px] text-emerald-800 font-black border-b border-emerald-900/30 pb-4'>
                                        <span>OPERATOR: " . strtoupper(auth()->user()->name) . "</span>
                                        <span>NODE: CANARY_01</span>
                                        <span class='animate-pulse text-emerald-500'>●_SESSION_ENCRYPTED</span>
                                    </div>
                                    <div class='text-emerald-400 leading-relaxed italic mb-6 text-base'>
                                        > " . ($record->technical_notes ?? 'NO FIELD DATA LOGGED. WAITING FOR SENSOR INPUT...') . "
                                    </div>
                                    <div class='grid grid-cols-3 gap-8 text-[10px] pt-4 border-t border-emerald-900/30 font-black uppercase text-emerald-900'>
                                        <div>VER_DATE: " . ($record->last_maintenance_at?->format('d.M.Y') ?? 'PENDING') . "</div>
                                        <div>SYS_ENTRY: " . $record->created_at->format('d.M.Y') . "</div>
                                        <div class='text-right'>LOC: 28.1248° N, 15.4300° W</div>
                                    </div>
                                </div>
                            ")),
                    ])
            ]);
    }

    /**
     * Versión simplificada y robusta de la tarjeta para evitar solapamientos
     */
    private static function getTacticalCard(string $label, string $value, string $color): HtmlString
    {
        $colors = [
            'amber' => 'border-amber-500 text-amber-600 bg-amber-50',
            'emerald' => 'border-emerald-500 text-emerald-600 bg-emerald-50',
            'blue' => 'border-blue-500 text-blue-600 bg-blue-50',
            'gray' => 'border-gray-500 text-gray-600 bg-gray-50',
            'danger' => 'border-red-500 text-red-600 bg-red-50',
        ];
        $c = $colors[$color] ?? $colors['gray'];

        return new HtmlString("
            <div class='border-2 border-gray-900 p-4 bg-white hover:bg-gray-50 transition-colors'>
                <p class='text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1'>// {$label}</p>
                <p class='text-xl font-black text-gray-900 tracking-tight leading-none'>{$value}</p>
            </div>
        ");
    }
}
