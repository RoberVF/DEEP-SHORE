<?php

namespace App\Filament\Widgets;

use App\Models\Route;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SurvivalAutonomy extends BaseWidget
{
    protected function getStats(): array
    {
        $activeRoute = Route::where('status', 'active')->first();

        if (!$activeRoute) {
            return [Stat::make('Current Autonomy', 'No active ops')];
        }

        // Simulacion: Una ruta media consume 2500kcal/dia
        $kcalPerDay = 2500;
        $totalKcal = $activeRoute->estimated_kcal ?? 0;
        $daysLeft = $totalKcal > 0 ? round($totalKcal / $kcalPerDay, 1) : 0;

        return [
            Stat::make('Mission Autonomy', $daysLeft . ' Days')
                ->description('Based on kcal inventory')
                ->icon('heroicon-m-bolt')
                ->color($daysLeft < $activeRoute->duration_days ? 'danger' : 'success'),

            Stat::make('Tactical Load', ($activeRoute->backpack->equipment->sum('weight_grams') / 1000) . ' kg')
                ->description('Total weight on back')
                ->icon('heroicon-m-beaker'),
        ];
    }
}
