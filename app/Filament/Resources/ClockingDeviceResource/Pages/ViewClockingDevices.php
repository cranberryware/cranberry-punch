<?php

namespace App\Filament\Resources\ClockInDeviceResource\Pages;

use App\Filament\Resources\ClockInDeviceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClockInDevices extends ViewRecord
{
    protected static string $resource = ClockInDeviceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
