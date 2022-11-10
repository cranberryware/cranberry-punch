<?php

namespace App\Filament\Widgets;

use App\Filament\Concerns\HasAttendanceCalendar;
use Filament\Widgets\TableWidget;

class AttendanceCalendar extends TableWidget
{
    use HasAttendanceCalendar;

    protected int | string | array $columnSpan = 2;

    protected static string $view = 'filament.widgets.attendance-calendar';

}
