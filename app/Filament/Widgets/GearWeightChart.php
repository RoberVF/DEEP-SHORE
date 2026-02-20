<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use Filament\Widgets\ChartWidget;

class GearWeightChart extends ChartWidget
{
    protected ?string $heading = 'Weight Distribution by Category (kg)';

    protected ?string $maxHeight = '300px';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Equipment::query()
            ->selectRaw('category, sum(weight_grams) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return [
            'datasets' => [
                [
                    'label' => 'Total Weight',
                    'data' => $data->map(fn($value) => $value / 1000)->values()->toArray(),
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.5)',
                        'rgba(234, 179, 8, 0.5)',
                        'rgba(239, 68, 68, 0.5)',
                        'rgba(59, 130, 246, 0.5)',
                        'rgba(168, 85, 247, 0.5)',
                    ],
                    'borderColor' => [
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(239, 68, 68)',
                        'rgb(59, 130, 246)',
                        'rgb(168, 85, 247)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $data->keys()->map(fn($key) => ucfirst($key))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
