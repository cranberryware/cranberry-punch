<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $start_check_in = '08:00:00';
        $end_check_in = '11:00:00';
        $start_check_out = '18:00:00';
        $end_check_out = '20:00:00';

        $current_month = Carbon::now()->month;
        $current_year = Carbon::now()->year;

        for ($month = 1; $month <= $current_month; $month++) {
            $last_day_of_month = ($month === $current_month)  ? Carbon::now()->day : Carbon::create($current_year, $month)->endOfMonth()->day;

            for ($day = 1; $day <= $last_day_of_month; $day++) {
                $date = Carbon::create($current_year, $month, $day)->toDateString();

                $employees = Employee::all();

                foreach ($employees as $employee) {
                    $check_in = Carbon::parse($date . ' ' . $start_check_in);
                    $check_out = Carbon::parse($date . ' ' . $start_check_out);

                    do {
                        $check_in = Carbon::parse($date . ' ' . $start_check_in)->addMinutes(rand(1, 180));
                    } while ($check_in->lt(Carbon::parse($date . ' ' . $end_check_in)));

                    do {
                        $check_out = Carbon::parse($date . ' ' . $start_check_out)->addMinutes(rand(1, 180));
                    } while ($check_out->lt(Carbon::parse($date . ' ' . $end_check_out)));

                    Attendance::create([
                        'user_id' => $employee->user_id,
                        'employee_id' => $employee->id,
                        'check_in' => $check_in->format('Y-m-d H:i:s'),
                        'check_out' => $check_out->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }
}
