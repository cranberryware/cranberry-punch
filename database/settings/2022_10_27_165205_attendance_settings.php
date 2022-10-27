<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AttendanceSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('attendance.ip_locations', [
            [
                "ip" => "127.0.0.1",
                "location" => "development"
            ]
        ]);
    }
}
