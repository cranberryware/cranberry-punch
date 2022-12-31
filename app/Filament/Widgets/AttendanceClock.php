<?php

namespace App\Filament\Widgets;

use Closure;
use App\Models\Attendance;
use Filament\Widgets\TableWidget;
use Filament\Tables\Actions\Action;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;

class AttendanceClock extends TableWidget
{
    protected static string $view = 'filament.widgets.attendance-clock-table-widget';

    protected static ?int $sort = -2;

    // protected int | string | array $columnSpan = 2;

    protected function getTableHeading(): string | Htmlable | Closure | null
    {
        return "";
    }

    public static function canView(): bool
    {
        if (auth()->user()->employee) {
            return true;
        } else {
            return false;
        }
    }

    protected function getTableQuery(): Builder
    {
        if(!auth()->user()->employee)
            return null;
        $query = Attendance::query()
            ->where('employee_id', auth()->user()->employee ? auth()->user()->employee->id : -1)
            ->orderBy('created_at', 'desc');
        if ($query->count() < 1) {
            auth()->user()->employee->attendance_clock();
            auth()->user()->employee->attendance_clock();
        }
        return Attendance::query()
            ->where('employee_id', auth()->user()->employee ? auth()->user()->employee->id : -1)
            ->orderBy('created_at', 'desc');
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return Container::getInstance()->makeWith(Paginator::class, [
            'items' => $query->get(['*'])->take(1),
            'perPage' => 1,
            'page' => 1
        ]);
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [1];
    }

    protected function getTableColumns(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        $attendance_clock_action = Action::make('attendance_clock')
            ->view('filament.tables.actions.attendance.clock-attendance-button-action')
            ->label(function (): string {
                return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                    ? __('cranberry-punch::cranberry-punch.attendance-kiosk.button.clock-in')
                    : __('cranberry-punch::cranberry-punch.attendance-kiosk.button.clock-out');
            })
            ->icon(function (): string {
                return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                    ? 'heroicon-o-login'
                    : 'heroicon-o-logout';
            })
            ->color(function (): string {
                return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                    ? 'success'
                    : 'danger';
            })
            ->action(function () {
                auth()->user()->employee->attendance_clock();
            })
            ->size('lg')
            ->requiresConfirmation();
        return [$attendance_clock_action];
    }
}
