<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use DateTime;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CheckInChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'checkInChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Check In Graph';

    // for adjusting the width
    public function getColumnSpan(): int | string | array
    {
        return 2;
    }


    protected function getFormSchema(): array
    {
        $user = auth()->user();
        $today = now();
        $months_list = [];
        $day = now();
        for ($i = 0; $i < 12; $i++) {
            $months_list[$day->format('Y-m-01')] = $day->format('F Y');
            $day->subMonth();
        }

        return [
            Select::make('month')
                ->label(__('cranberry-punch::cranberry-punch.attendance.filter.attendance_month'))
                ->disablePlaceholderSelection()
                ->options($months_list)
                ->default($today->format('Y-m-01')),
            Select::make('user_id')
                ->label(strval(__('cranberry-punch::cranberry-punch.attendance.filter.employee')))
                ->searchable()
                ->default($user->id)
                ->options(Employee::pluck('employee_code_with_full_name', 'user_id'))
                ->getOptionLabelsUsing(fn (array $values) => Employee::whereIn('user_id', $values)->pluck('employee_code_with_full_name', 'id')->toArray())
                ->hidden(!$user->hasRole(['hr-manager', 'super-admin'])),
        ];
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {

        $activeFilter = $this->filterFormData;

        $data = Attendance::where('user_id', $activeFilter['user_id'])
                    ->where('attendance_month', $activeFilter['month'])
                    ->orderBy('check_in', 'asc') // Order by check-in time ascending
                    ->get()
                    ->groupBy(function ($attendance) {
                        return date('Y-m-d', strtotime($attendance->check_in)); // Group by date
                    })
                    ->map(function ($groupedAttendances) {
                        return $groupedAttendances->first()->check_in; // Get the first check-in time of each day
                    })
                    ->toArray();

        $days = array_map(function ($value) {
            return date('d', strtotime($value));
        }, array_keys($data));

        $times = array_map(function ($value) {
            return date('h:i', strtotime($value));
        }, array_values($data));

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'CheckIn time',
                    'data' => $times,
                ],
            ],
            'xaxis' => [
                'categories' => $days,
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'CheckIn Time',
                ],
                'type' => 'datetime',
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'noData' => [
                'text' => "No records found",
                'align' => 'center',
                'verticalAlign' => 'middle',
                'offsetX' => 0,
                'offsetY' => 0,
                'style' => [
                    'color' => "#4F9769",
                    'fontSize' => '20px',
                    'fontFamily' => 'Helvetica, Arial, sans-serif',
                    'fontWeight' => 600,
                ]
            ],
            'colors' => ['#4F9769'],
            'stroke' => [
                'width' => 2,
                'curve' => 'smooth',
            ],
        ];
    }


    protected function getHeading(): string
    {
        $activeFilter = $this->filterFormData;
        $date = Carbon::parse($activeFilter['month'])->format('F Y');
        $user = Employee::where('user_id', $activeFilter['user_id'])->value('employee_code_with_full_name');
        $html = sprintf('<p style="font-size: 14px; line-height: 1.2;"><span class="text-2xl font-medium">CheckIn Time Chart</span><br/><br/> Attendance Month is (%s) &nbsp &nbsp &nbsp  &nbsp Employee is (%s)</p>', $date, $user);
        return new HtmlString($html);
    }


    protected function getFooter(): string
    {
        return new HtmlString('<span style="display:flex; justify-content:center; font-size:12px;font-weight:700;">Dates</span>');
    }
}
