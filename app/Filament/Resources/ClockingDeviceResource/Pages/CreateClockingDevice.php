<?php

namespace App\Filament\Resources\ClockingDeviceResource\Pages;

use App\Filament\Resources\ClockingDeviceResource;
use App\Helpers\Helper\Helper;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClockingDevice extends CreateRecord
{
    protected static string $resource = ClockingDeviceResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
