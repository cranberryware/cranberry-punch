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
            [
                "name"=>"National",
                "slug"=>"national",
                "holiday_color"=>"bg-indigo-500"
            ],
            [
                "name"=>"Regional",
                "slug"=>"regional",
                "holiday_color"=>"bg-teal-400"
            ],
            [
                "name"=>"Other",
                "slug"=>"other",
                "holiday_color"=>"bg-amber-400"
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
        $this->migrator->delete('attendance.holiday_types');
    }

};
