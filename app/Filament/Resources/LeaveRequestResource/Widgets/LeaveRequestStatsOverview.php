<?php

namespace App\Filament\Resources\LeaveRequestResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class LeaveRequestStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Vacation Leave', 3),
            Card::make('Sick Leave', '21%'),
            Card::make('Average time on page', '3:12'),
        ];
    }
}
