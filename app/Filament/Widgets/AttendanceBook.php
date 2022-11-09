<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AttendanceBook extends TableWidget
{
    protected int | string | array $columnSpan = 2;

    protected static string $view = 'filament.widgets.attendance-book';

    protected array $month_dates = [];

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['super-admin', 'hr-manager']);
    }

    private function getMonthDates($month_selected): array
    {
        $month_dates = [];

        $start_of_month = Carbon::parse($month_selected)->startOfMonth();
        $end_of_month = Carbon::parse($month_selected)->endOfMonth();
        while ($start_of_month->lte($end_of_month)) {
            $date = $start_of_month->copy();
            $date = $date->format('Y-m-d');
            $month_dates[] = $date;
            $start_of_month->addDay();
        }
        return $month_dates;
    }

    protected function getTableQuery(): Builder
    {
        $columns = ["employee_id"];

        $month_selected = $this->tableFilters["attendance_month"]["value"];
        $month_dates = $this->getMonthDates($month_selected);

        foreach($month_dates as $month_date) {
            $date = explode("-", $month_date);
            $date = end($date);
            $columns[] = DB::raw("
                SUM(
                    CASE
                        WHEN DATE_FORMAT(attendance_day, '%Y-%m-%d') = '{$month_date}' THEN worked_hours
                        ELSE NULL
                    END
                ) AS `{$month_date}`
            ");
        }

        return Attendance::query()
            ->select($columns)
            ->groupBy(["attendance_day", "employee_id"]);
    }

    public function getTableRecordKey(Model $record): string
    {
        return "employee-id-{$record->employee_id}";
    }

    protected function getTableFilters(): array
    {
        $today = Carbon::parse(DB::select(DB::raw('SELECT NOW() AS ctime'))[0]->ctime);
        $months_list = [];
        $day = now();
        for ($i = 0; $i < 12; $i++) {
            $months_list[$day->format('Y-m-01')] = $day->format('F Y');
            $day->subMonth(1);
        }
        return [
            SelectFilter::make('attendance_month')
                ->options($months_list)
                ->default($today->format('Y-m-01'))
        ];
    }

    protected function getTableColumns(): array
    {
        $columns = [
            TextColumn::make("employee.employee_code_with_full_name"),
        ];
        $month_dates = $this->getMonthDates("2022-11-01");
        foreach ($month_dates as $month_date) {
            // $date = explode("-", $month_date);
            // $date = end($date);
            $columns[] = TextColumn::make($month_date);
        }
        return $columns;
    }
}
