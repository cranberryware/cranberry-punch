<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AttendanceSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('attendance.work_ips', []);
    }
}
