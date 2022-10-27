<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 31; $i++) {
            $faker = \Faker\Factory::create();
            for ($j = 0; $j <= 12; $j++) {
                $start_check_in = \Carbon\Carbon::parse(now()->subDays($i)->toDateString() . " 08:00:00");
                $end_check_in = \Carbon\Carbon::parse(now()->subDays($i)->toDateString() . " 11:00:00");
                $start_check_out = \Carbon\Carbon::parse(now()->subDays($i)->toDateString() . " 17:00:00");
                $end_check_out = \Carbon\Carbon::parse(now()->subDays($i)->toDateString() . " 20:00:00");
                $employee = Employee::inRandomOrder()->first();
                $attendance = Attendance::create([
                    'user_id' => $employee->user_id,
                    'employee_id' => $employee->id,
                    'check_in' => $faker->dateTimeBetween($start_check_in, $end_check_in),
                    'check_out' => $faker->dateTimeBetween($start_check_out, $end_check_out),
                ]);
            }
        }
    }
}
