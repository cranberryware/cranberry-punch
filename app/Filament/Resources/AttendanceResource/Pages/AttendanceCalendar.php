<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Table;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AttendanceResource;
use App\Filament\Concerns\HasAttendanceCalendar;
use Filament\Tables\Actions\EditAction;

class AttendanceCalendar extends ListRecords
{
    use HasAttendanceCalendar;

    protected static string $resource = AttendanceResource::class;

    protected function table(Table $table): Table
    {
        return $table;
    }

}
