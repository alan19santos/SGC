<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            // coloque seus widgets aqui
            // Ex:
            // \App\Filament\Widgets\AdminStats::class,
            // \App\Filament\Widgets\CondominiumsChart::class,
            \App\Filament\Widgets\UsersChat::class,
            \App\Filament\Widgets\CondominiumsChart::class ,
        ];
    }
}
