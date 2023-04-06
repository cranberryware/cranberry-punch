<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Helpers\Helper\Helper;
use Filament\Resources\Pages\CreateRecord;
use Filament\Pages\Actions\Action;
class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getRedirectUrl(): string
    {
        return Helper::getRedirectUrl($this);
    }

}
