<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holidays = [
            [
                'date' => Carbon::parse('2023-01-01'),
                'day_name' => 'Sunday',
                'holiday_name' => 'New Year\'s Day',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-01-14'),
                'day_name' => 'Saturday',
                'holiday_name' => 'Makar Sankranti',
                'holiday_type' => 'regional',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-01-26'),
                'day_name' => 'Thursday',
                'holiday_name' => 'Republic Day',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-02-19'),
                'day_name' => 'Sunday',
                'holiday_name' => 'Shivaji Jayanti',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-03-11'),
                'day_name' => 'Saturday',
                'holiday_name' => 'Maha Shivaratri',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-03-29'),
                'day_name' => 'Wednesday',
                'holiday_name' => 'Holi',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-04-01'),
                'day_name' => 'Saturday',
                'holiday_name' => 'Bank Holiday',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-04-09'),
                'day_name' => 'Sunday',
                'holiday_name' => 'Mahavir Jayanti',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-04-14'),
                'day_name' => 'Friday',
                'holiday_name' => 'Good Friday',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-04-17'),
                'day_name' => 'Monday',
                'holiday_name' => 'Easter Monday',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-05-01'),
                'day_name' => 'Monday',
                'holiday_name' => 'May Day/Labour Day',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-05-10'),
                'day_name' => 'Wednesday',
                'holiday_name' => 'Buddha Purnima/Vesak Day',
                'holiday_type' => 'regional',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-06-26'),
                'day_name' => 'Monday',
                'holiday_name' => 'Eid al-Fitr',
                'holiday_type' => 'national',
                'is_confirmed' => false
            ],
            [
                'date' => Carbon::parse('2023-08-15'),
                'day_name' => 'Tuesday',
                'holiday_name' => 'Independence Day',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-08-22'),
                'day_name' => 'Tuesday',
                'holiday_name' => 'Bakrid/Eid al-Adha',
                'holiday_type' => 'national',
                'is_confirmed' => false
            ],
            [
                'date' => Carbon::parse('2023-09-02'),
                'day_name' => 'Saturday',
                'holiday_name' => 'Ganesh Chaturthi/Vinayaka Chaturthi',
                'holiday_type' => 'national',
                'is_confirmed' => false
            ],
            [
                'date' => Carbon::parse('2023-09-30'),
                'day_name' => 'Saturday',
                'holiday_name' => 'Dussehra (Vijayadashami)',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-10-02'),
                'day_name' => 'Monday',
                'holiday_name' => 'Mahatma Gandhi Jayanti',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-10-20'),
                'day_name' => 'Friday',
                'holiday_name' => 'Diwali/Deepavali',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-11-04'),
                'day_name' => 'Saturday',
                'holiday_name' => 'Guru Nanak Jayanti',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-11-24'),
                'day_name' => 'Friday',
                'holiday_name' => 'Guru Teg Bahadur\'s Martyrdom Day',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
            [
                'date' => Carbon::parse('2023-12-25'),
                'day_name' => 'Monday',
                'holiday_name' => 'Christmas Day',
                'holiday_type' => 'national',
                'is_confirmed' => true
            ],
        ];
        foreach ($holidays as $holiday) {
            Holiday::create([
                'date' => $holiday['date']->format('Y-m-d'),
                'holiday_name' => $holiday['holiday_name'],
                'holiday_type' => $holiday['holiday_type'],
                'is_confirmed' => $holiday['is_confirmed']
            ]);
        }
    }
}
