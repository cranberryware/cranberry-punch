<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class WeekendOffCellColors extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('attendance.weekend_off_cell_colors', []);
    }
}
