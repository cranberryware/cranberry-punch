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
        $this->migrator->add('attendance.weekly_day_offs', [
            "First Saturday",
            "First Sunday",
            "Second Saturday",
            "Second Sunday",
            "Third Saturday",
            "Third Sunday",
            "Fourth Saturday",
            "Fourth Sunday",
            "Fifth Saturday",
            "Fifth Sunday",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->migrator->delete('attendance.weekly_day_offs');
    }
};
