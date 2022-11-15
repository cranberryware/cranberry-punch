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
        $this->migrator->add('attendance.calendar_cell_colors', [
            [
                "max_value" => "0.1",
                "background_color" => "bg-red-600"
            ],
            [
                "max_value" => "5",
                "background_color" => "bg-amber-500"
            ],
            [
                "max_value" => "8",
                "background_color" => "bg-green-400"
            ],
            [
                "max_value" => "12",
                "background_color" => "bg-green-700"
            ],
            [
                "max_value" => "24",
                "background_color" => "bg-amber-300"
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
        $this->migrator->delete('attendance.calendar_cell_colors');
    }
};
