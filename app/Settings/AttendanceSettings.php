<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AttendanceSettings extends Settings
{

    public array $work_ips;

    public static function group(): string
    {
        return 'attendance';
    }
}
