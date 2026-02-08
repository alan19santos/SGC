<?php

namespace App\Filament\Widgets;
use App\Models\Condominium;
use Filament\Widgets\ChartWidget;

class CondominiumsChart extends ChartWidget
{
    protected static ?string $heading = 'Condomínios por status';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Condomínios',
                    'data' => [
                        Condominium::whereNotNull('deleted_at')->count(),
                        Condominium::whereNull('deleted_at')->count(),
                    ],
                ],
            ],
            'labels' => ['Inativos', 'Ativos'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
