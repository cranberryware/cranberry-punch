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

    protected function getActions(): array
    {
        return [
            Actions\Action::make('attendance_list')
                ->label(__('open-attendance::open-attendance.attendance.action.attendance_list_view'))
                ->icon('heroicon-o-view-list')
                ->action(function () {
                    return redirect()->route('filament.resources.attendances.index');
                }),
            Actions\CreateAction::make()
                ->label(__('open-attendance::open-attendance.attendance.action.create'))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function table(Table $table): Table
    {
        return $table;
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }
}
