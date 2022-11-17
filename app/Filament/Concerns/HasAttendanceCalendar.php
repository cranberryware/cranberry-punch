<?php

namespace App\Filament\Concerns;

use App\Models\Attendance;
use App\Models\Employee;
use App\Settings\AttendanceSettings;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait HasAttendanceCalendar
{
    protected ?string $defaultSortDirection = "asc";

    protected function getTable(): Table
    {
        $table = parent::getTable();
        return $table;
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
        $columns = [DB::raw("employee_id AS id"), "employee_id"];

        $month_selected = $this->getTableFilterState("attendance_month")["value"];
        $month_dates = $this->getMonthDates($month_selected);

        foreach ($month_dates as $month_date) {
            $date = explode("-", $month_date);
            $date = end($date);
            $columns[] = DB::raw("
                CONCAT(
                    '{$month_date} = ',
                    CAST(ROUND(
                        SUM(
                            CASE
                                WHEN DATE_FORMAT(attendance_day, '%Y-%m-%d') = '{$month_date}' THEN worked_hours
                                ELSE 0
                            END
                        )
                    , 2) AS CHAR)
                ) AS `{$date}`
            ");
        }

        return Attendance::query()
            ->select($columns)
            ->groupBy(["employee_id"])
            ->whereNotNull("check_out");
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

            Filter::make('attendance_month')
                ->form([
                    Select::make('value')
                        ->label(strval(__('open-attendance::open-attendance.attendance.filter.attendance_month')))
                        ->disablePlaceholderSelection()
                        ->options($months_list)
                        ->default($today->format('Y-m-01')),
                ])
                ->indicateUsing(function (array $data): ?string {
                    if (!$data['value']) {
                        return null;
                    }

                    return __('open-attendance::open-attendance.attendance.filter.indicator.attendance_month', ["attendance_month" => Carbon::parse($data['value'])->format('F Y')]);
                }),
            Filter::make('employee')
                ->form([
                    Select::make('id')
                        ->label(strval(__('open-attendance::open-attendance.attendance.filter.employee')))
                        ->searchable()
                        ->multiple()
                        ->getSearchResultsUsing(fn (string $search) => Employee::where('employee_code_with_full_name', 'like', "%{$search}%")
                            ->limit(10)
                            ->pluck('employee_code_with_full_name', 'id')
                            ->toArray())
                        ->getOptionLabelsUsing(fn (array $values) => Employee::whereIn('id', $values)->pluck('employee_code_with_full_name', 'id')->toArray()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['id'],
                            fn (Builder $query, $employee_ids): Builder => $query->whereIn('employee_id', $employee_ids),
                        );
                })
                ->hidden(function () {
                    return !auth()->user()->hasRole(['hr-manager', 'super-admin']);
                })
                ->indicateUsing(function (array $data): ?string {
                    $indicators = [];

                    if (empty($data['id']) || count($data['id']) < 1) {
                        return null;
                    }

                    $employees = Employee::whereIn('id', $data['id'])->pluck('employee_code_with_full_name');

                    foreach ($employees as $employee_code_with_full_name) {
                        $indicators[] = $employee_code_with_full_name;
                    }

                    return __('open-attendance::open-attendance.attendance.filter.indicator.employee', ["employees" => join(', ', $indicators)]);
                }),
        ];
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
        ];

        $month_dates = $this->getMonthDates("2022-01-01");

        foreach ($month_dates as $month_date) {
            $date = explode("-", $month_date);
            $date = end($date);
            $columns[] = TextColumn::make("{$date}")
                ->extraAttributes(function (Model $record) use ($date) {
                    $calendar_cell_colors = app(AttendanceSettings::class)->calendar_cell_colors;
                    $weekly_day_offs = app(AttendanceSettings::class)->weekly_day_offs;

                    $first_max_value = reset($calendar_cell_colors);

                    $cell_value = $record->{$date};
                    $cell_value_arr = explode(' = ', $cell_value);
                    $cell_value_date = reset($cell_value_arr);
                    $cell_value_date = Carbon::parse($cell_value_date);
                    $cell_value = end($cell_value_arr);

                    $cell_value_month = $cell_value_date->format('Y-m');

                    $classes = 'text-sm w-16';

                    $classes .= " day-" . strtolower($cell_value_date->format('l'));

                    foreach($weekly_day_offs as $weekly_day_off) {
                        $weekly_day_off_date = Carbon::parse("{$weekly_day_off} {$cell_value_month}");
                        if($cell_value_date->eq($weekly_day_off_date) && empty($cell_value)) {
                            $classes .= " bg-primary-500 text-white";
                        }
                    }

                    if($cell_value_date->gt(today())) {
                        return [
                            'class' => "{$classes} bg-primary-200"
                        ];
                    }

                    if($cell_value_date->eq(today())) {
                        return [
                            'class' => "{$classes} bg-primary-200 animate-pulse"
                        ];
                    }

                    if ($cell_value === null || $cell_value === "") {
                        return [
                            'class' => "{$classes} bg-white"
                        ];
                    }
                    usort($calendar_cell_colors, function ($a, $b) {
                        return $a['max_value'] > $b['max_value'];
                    });
                    foreach ($calendar_cell_colors as $calendar_cell_color) {
                        $max_value = floatval($calendar_cell_color['max_value']);
                        $bg_color_class = $calendar_cell_color['background_color'];
                        $bg_color_class_array = explode('-', $bg_color_class);
                        $bg_color_class_darkness = end($bg_color_class_array);
                        if (floatval($cell_value) < $max_value) {
                            $text_color_class = ($bg_color_class_darkness > 400) ? 'text-white' : 'text-black';
                            $extra_css_classes = isset($calendar_cell_color['extra_css_classes']) && is_array($calendar_cell_color['extra_css_classes']) ? join(" ", $calendar_cell_color['extra_css_classes']) : "";
                            return [
                                'class' => "{$classes} {$bg_color_class} {$text_color_class} {$extra_css_classes}"
                            ];
                        }
                    }
                    return [];
                })
                ->getStateUsing(function (Model $record) use ($date) {
                    $calendar_cell_colors = app(AttendanceSettings::class)->calendar_cell_colors;
                    $weekly_day_offs = app(AttendanceSettings::class)->weekly_day_offs;
                    usort($calendar_cell_colors, function ($a, $b) {
                        return $a['max_value'] > $b['max_value'];
                    });
                    $first_max_value = reset($calendar_cell_colors);

                    $cell_value = $record->{$date};
                    $cell_value_arr = explode(' = ', $cell_value);
                    $cell_value_date = reset($cell_value_arr);
                    $cell_value_date = Carbon::parse($cell_value_date);
                    $cell_value = end($cell_value_arr);
                    $cell_value_month = $cell_value_date->format('Y-m');


                    foreach($weekly_day_offs as $weekly_day_off) {
                        $weekly_day_off_date = Carbon::parse("{$weekly_day_off} {$cell_value_month}");
                        if($cell_value_date->eq($weekly_day_off_date) && empty($cell_value)) {
                            return $cell_value_date->format('D');
                        }
                    }

                    if($cell_value_date->gt(today()) || $cell_value === null || $cell_value === "") {
                        return '';
                    }

                    if($cell_value_date->eq(today())) {
                        return $cell_value;
                    }

                    if (floatval($cell_value) < floatval($first_max_value['max_value'])) {
                        return '-';
                    }

                    return $cell_value;
                })
                ->tooltip(function (Model $record) use ($date) {
                    $calendar_cell_colors = app(AttendanceSettings::class)->calendar_cell_colors;
                    usort($calendar_cell_colors, function ($a, $b) {
                        return $a['max_value'] > $b['max_value'];
                    });
                    $first_max_value = reset($calendar_cell_colors);
                    $cell_value = $record->{$date};
                    $cell_value_arr = explode(' = ', $cell_value);
                    $cell_value_date = reset($cell_value_arr);
                    $cell_value_date = Carbon::parse($cell_value_date);
                    $cell_value = end($cell_value_arr);
                    $cell_value_month = $cell_value_date->format('Y-m');

                    if($cell_value_date->gte(today()) || $cell_value === null || $cell_value === "") {
                        return '';
                    }

                    $hours = $record->{$date};
                    return empty($hours) ? null : "{$hours} Hours";
                })
                ->alignCenter();
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

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50, 100, 150];
    }
}
