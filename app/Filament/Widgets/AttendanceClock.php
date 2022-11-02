<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;

class AttendanceClock extends TableWidget
{

    protected function getTableQuery(): Builder
    {
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
                    ? __('open-attendance::open-attendance.attendance-kiosk.button.clock-in')
                    : __('open-attendance::open-attendance.attendance-kiosk.button.clock-out');
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
