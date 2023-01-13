<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class HolidaySettings extends SettingsMigration
{
    public function up(): void
    {

        $this->migrator->add('attendance.holidays_type', []);
        $this->migrator->add('attendance.holiday_type_color', 'bg-cyan-500');
    }
    public function down(): void
    {
        $this->migrator->delete('attendance.holidays_type');
    }
}
