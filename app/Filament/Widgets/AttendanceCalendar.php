<?php

namespace App\Filament\Widgets;

use App\Filament\Concerns\HasAttendanceCalendar;
use Filament\Widgets\TableWidget;

class AttendanceCalendar extends TableWidget
{
    use HasAttendanceCalendar;

    // protected int | string | array $columnSpan = 2;

    protected static string $view = 'filament.widgets.attendance-calendar';

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5];
    }

    public function getColumnSpan(): int | string | array
    {
        if (auth()->user()->hasRole(['employee'])) {
            return 2;
        }
        return 1;
    }
}
