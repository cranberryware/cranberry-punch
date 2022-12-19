<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Concerns\HasRecordClasses;
use Illuminate\Database\Eloquent\Model;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('attendance_calendar')
                ->extraAttributes([
                    'class' => 'custom-button'
                ])
                ->label(__('open-attendance::open-attendance.attendance.action.attendance_calendar_view'))
                ->icon('heroicon-o-calendar')
                ->action(function () {
                    return redirect()->route('filament.resources.attendances.attendance-calendar');
                }),
            Actions\CreateAction::make()
                ->extraAttributes([
                    'class' => 'custom-button'
                ])
                ->label(__('open-attendance::open-attendance.attendance.action.create'))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTableRecordClassesUsing(): ?Closure
    {
        return fn (Model $record) => match ($record->check_out) {
            null => [
                'animate-pulse',
                'bg-primary-200'
            ],
            default => (function () use ($record) {
                return [
                ];
            })(),
        };
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100, 150];
    }
}
