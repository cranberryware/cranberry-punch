<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Forms\Components\Select;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\Position;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;

class AttendanceClock extends TableWidget
{
    protected function getTableQuery(): Builder
    {
        return Attendance::query()
            ->where('employee_id', auth()->user()->employee->id)
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
        return [
            // TextColumn::make('check_in')
            //     ->view('filament.tables.columns.attendance.clock-column-mini'),
            // TextColumn::make('check_out')
            //     ->view('filament.tables.columns.attendance.clock-column-mini')
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('attendance_clock')
                ->view('filament.tables.actions.attendance.clock-attendance-action')
                ->label(function (): string {
                    return (auth()->user()->employee && auth()->user()->employee->clocked_out())
                        ? __('open-attendance::open-attendance.attendance-kiosk.button.clock-in')
                        : __('open-attendance::open-attendance.attendance-kiosk.button.clock-out');
                })
                ->button()
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
                ->extraAttributes([
                    'class' => 'px-8 py-10'
                ])
                ->size('lg')
                ->requiresConfirmation(),
        ];
    }

    protected function getActionsPosition(): string
    {
        return Position::BeforeCells;
    }
}
