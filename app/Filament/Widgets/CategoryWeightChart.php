<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use Filament\Widgets\ChartWidget;

class CategoryWeightChart extends ChartWidget
{
    protected ?string $heading = 'Weight by Category (kg)';
    protected static ?int $sort = 3;
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Equipment::query()
            ->selectRaw('category, sum(weight_grams) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        return [
            'datasets' => [
                [
                    'label' => 'Weight',
                    'data' => $data->map(fn($value) => $value / 1000)->values(),
                    'backgroundColor' => ['#16a34a', '#ca8a04', '#dc2626', '#2563eb'],
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
