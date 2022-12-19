<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAttendance extends ViewRecord
{
    protected static string $resource = AttendanceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()->extraAttributes([
                'class' => 'custom-button'
            ]),
        ];
    }
}
