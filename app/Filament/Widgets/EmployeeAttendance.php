<?php

namespace App\Filament\Widgets;

use App\Filament\Concerns\HasAttendanceCalendar;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\User;
use App\Settings\AttendanceSettings;
use Carbon\Carbon;
use Closure;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends TableWidget
{

    use HasAttendanceCalendar;
    protected static string $view = 'filament.widgets.attendance-calendar';

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5];
    }
    protected function getTableQuery(): Builder
    {
       
        return Attendance::query()
        // ->where('employee_id', auth()->user()->id)
        ;
    }

    protected function getTableColumns(): array
    {
        $columns = [
            TextColumn::make("employee.employee_code_with_full_name")
                ->sortable(true)
                ->searchable(true)
                ->extraAttributes([
                    'class' => 'font-bold text-sm'
                ]),
            // TextColumn::make("check_in")
            // ->sortable(true)
            // ->searchable(true)
            // ->time()
            // ->extraAttributes([
            //     'class' => 'font-bold text-sm',
            // ]),

        ];
        $months_dds = $this->getMonthDates($this->selectedMonth);
        foreach ($months_dds as $month_date) {
            $date = explode("-", $month_date);
            $date = end($date);
            $columns[] = TextColumn::make("{$date}")->time()
                ->getStateUsing(function (Model $record) use ($date) {
                    $time = Attendance::query()->where('employee_id',  auth()->user()->id)->get();
                //  dd($time);
                    foreach($time as $value){
                        $check_in = ($value->check_in);
                    //    return $check_in;
                    }
                    return $check_in;
                });
        }
        return $columns;
    }
}
