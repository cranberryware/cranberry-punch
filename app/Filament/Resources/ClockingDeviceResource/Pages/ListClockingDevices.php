<?php

namespace App\Filament\Resources\ClockingDeviceResource\Pages;

use App\Filament\Resources\ClockingDeviceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClockingDevices extends ListRecords
{
    protected static string $resource = ClockingDeviceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
