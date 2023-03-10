<?php

namespace App\Filament\Resources\ClockingDeviceResource\Pages;

use App\Filament\Resources\ClockingDeviceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClockingDevice extends EditRecord
{
    protected static string $resource = ClockingDeviceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
