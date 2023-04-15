<?php

namespace App\Filament\Resources\ClockingDeviceResource\Pages;

use App\Filament\Resources\ClockingDeviceResource;
use App\Helpers\Helper\Helper;
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
