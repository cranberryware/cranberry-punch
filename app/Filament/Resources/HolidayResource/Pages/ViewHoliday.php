<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHoliday extends ViewRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
