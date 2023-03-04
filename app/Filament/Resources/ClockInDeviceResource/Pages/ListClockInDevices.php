<?php

namespace App\Filament\Resources\ClockInDeviceResource\Pages;

use App\Filament\Resources\ClockInDeviceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClockInDevices extends ListRecords
{
    protected static string $resource = ClockInDeviceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
