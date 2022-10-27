<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AttendanceSettings extends Settings
{
    public array $ip_locations;

    public static function group(): string
    {
        return 'attendance';
    }
}
