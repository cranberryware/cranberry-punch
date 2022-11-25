<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AttendanceSettings extends Settings
{
    public array $ip_locations;

    public array $calendar_cell_colors;
    public array $weekly_day_offs;

    public static function group(): string
    {
        return 'attendance';
    }
}
