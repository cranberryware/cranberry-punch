<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as das;

class Dashboard extends das
{
    protected function getColumns(): int | array
    {
        if (auth()->user()->roles[0]->id == 3)
            return 3;
        else
            return 2;
    }
}
