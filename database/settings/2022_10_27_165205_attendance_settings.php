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
        $this->migrator->add('attendance.ip_locations', [
            [
                "ip" => "127.0.0.1",
                "location" => "development"
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->migrator->delete('attendance.ip_locations');
    }
};
