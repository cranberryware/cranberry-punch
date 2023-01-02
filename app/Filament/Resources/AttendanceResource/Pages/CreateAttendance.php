<?php

namespace App\Filament\Resources\AttendanceResource\Pages;
use Filament\Pages\Actions\Action;

use App\Filament\Resources\AttendanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;

}
