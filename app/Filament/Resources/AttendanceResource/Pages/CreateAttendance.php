<?php

namespace App\Filament\Resources\AttendanceResource\Pages;
use Filament\Pages\Actions\Action;

use App\Filament\Resources\AttendanceResource;
use App\Helpers\Helper\Helper;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;

    protected function getRedirectUrl(): string
    {
        return Helper::getRedirectUrl($this);
    }

}
