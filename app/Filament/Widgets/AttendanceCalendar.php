<?php

namespace App\Filament\Widgets;

use App\Filament\Concerns\HasAttendanceCalendar;
use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttendanceCalendar extends TableWidget
{
    use HasAttendanceCalendar;

    protected int | string | array $columnSpan = 2;

    protected static string $view = 'filament.widgets.attendance-calendar';

    protected array $month_dates = [];

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['super-admin', 'hr-manager']);
    }
}
