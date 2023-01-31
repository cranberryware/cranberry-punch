<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class HolidaySettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('attendance.holiday_type', []);
    }
    public function down(): void
    {
        $this->migrator->delete('attendance.holiday_type');
    }
}
