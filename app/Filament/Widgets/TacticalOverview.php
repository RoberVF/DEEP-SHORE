<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use App\Models\Route;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TacticalOverview extends BaseWidget
{

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Asset Value', '€' . number_format(Equipment::sum('price'), 2))
                ->description('Total investment in gear')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8])
                ->color('success'),
            Stat::make('Active Routes', Route::where('status', 'active')->count())
                ->description('Operations currently in field')
                ->icon('heroicon-m-map'),
            Stat::make('Maintenance Required', Equipment::where('condition', 'damaged')->count())
                ->description('Items needing immediate repair')
                ->color('danger'),
        ];
    }
}
