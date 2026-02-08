<?php

namespace App\Filament\Widgets;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class UsersChat extends ChartWidget
{
    protected static ?string $heading = 'Gráfico de Usuários';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Usuários',
                    'data' => [
                        User::whereNull('deleted_at')->count(),
                        User::whereNotNull('deleted_at')->count(),
                    ],
                ],
            ],
            'labels' => ['Ativos', 'Inativos'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
