<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->migrator->add('attendance.holiday_types', [
            "national_holiday" => "National Holiday",
            "regional_holiday" => "Regional Holiday",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->migrator->delete('attendance.holiday_types');
    }
};
