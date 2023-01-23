<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateHolidaySettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('attendance.holiday_types', []);
    }
}
