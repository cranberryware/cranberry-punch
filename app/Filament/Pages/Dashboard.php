<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as das;

class Dashboard extends das
{
    protected function getColumns(): int | array
    {
        if (auth()->user()->hasRole(['employee','hr-manager'])) {
            return 3;
        }
        return 2;
    }
}
