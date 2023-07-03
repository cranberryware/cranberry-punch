<?php

namespace App\Filament\Resources\ClockingDeviceResource\Pages;

use App\Filament\Resources\ClockingDeviceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClockingDevices extends ViewRecord
{
    protected static string $resource = ClockingDeviceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
