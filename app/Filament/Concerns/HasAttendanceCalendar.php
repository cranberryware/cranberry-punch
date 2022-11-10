<?php

namespace App\Filament\Concerns;

use App\Models\Attendance;
use Carbon\Carbon;
use Closure;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait HasAttendanceCalendar
{
    protected ?string $defaultSortDirection = "asc";

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
        $columns = [DB::raw("employee_id AS id"), "employee_id"];

        $month_selected = $this->getTableFilterState("attendance_month")["value"];
        $month_dates = $this->getMonthDates($month_selected);

        foreach ($month_dates as $month_date) {
            $date = explode("-", $month_date);
            $date = end($date);
            $columns[] = DB::raw("
                ROUND(
                    SUM(
                        CASE
                            WHEN DATE_FORMAT(attendance_day, '%Y-%m-%d') = '{$month_date}' THEN worked_hours
                            ELSE NULL
                        END
                    )
                , 2) AS `{$date}`
            ");
        }

        return Attendance::query()
            ->select($columns)
            ->groupBy(["employee_id"]);
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
                ->default($today->format('Y-m-01')),
        ];
    }

    protected function getTableColumns(): array
    {
        $columns = [
            TextColumn::make("employee.employee_code_with_full_name")
                ->sortable(true),
        ];

        $month_dates = $this->getMonthDates("2022-01-01");
        foreach ($month_dates as $month_date) {
            $date = explode("-", $month_date);
            $date = end($date);
            $columns[] = TextColumn::make("{$date}")
                ->sortable(false);
        }
        return $columns;
    }

    public function getDefaultTableSortColumn(): ?string
    {
        return "employee.employee_code_with_full_name";
    }

    public function getDefaultTableSortDirection(): ?string
    {
        return "asc";
    }

    protected function getTableRecordClassesUsing(): ?Closure
    {
        return fn (Model $record) => match ($record->getKey()%2) {
            0 => [
                'even',
                'bg-primary-200'
            ],
            default => (function () use ($record) {
                return [
                ];
            })(),
        };
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }
}
