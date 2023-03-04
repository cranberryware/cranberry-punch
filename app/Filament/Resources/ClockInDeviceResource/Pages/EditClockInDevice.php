<?php

namespace App\Filament\Resources\ClockInDeviceResource\Pages;

use App\Filament\Resources\ClockInDeviceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClockInDevice extends EditRecord
{
    protected static string $resource = ClockInDeviceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
