<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        // ])->assignRole('super-admin');

        $faker = Factory::create();
        $gender = $faker->randomElement(['male', 'female']);
        $opposite_gender = $gender == "male" ? "female" : "male";
        $marital_status = $faker->randomElement(['married', 'unmarried']);
        $is_married = ($marital_status == "married");
        $first_name = 'Admin';
        $last_name = 'User';
        $work_email = 'admin@example.com';
        Employee::create([
            'employee_code' => sprintf("NTE-%03d", 1),
            'user_id' => User::factory()->create([
                'name' => "{$first_name} {$last_name}",
                'email' => $work_email,
                'password' => Hash::make('password'),
            ])->assignRole('super-admin')->id,
            'department_id' => Department::inRandomOrder()->pluck('id')->first(),
            'designation_id' => Designation::inRandomOrder()->pluck('id')->first(),
            'manager_id' => rand(0, 10) > 6 ? Employee::inRandomOrder()->pluck('id')->first() : null,

            // Personal
            'first_name' => $first_name,
            'middle_name' => "",
            'last_name' => $last_name,
            'gender' => $gender, // ['male', 'female', 'other']
            'date_of_birth' => $faker->dateTimeBetween('1970-01-01', '2004-01-01'),
            'birthday' => $faker->dateTimeBetween('1970-01-01', '2004-01-01'),
            'blood_group' => $faker->randomElement(['A+', 'A−', 'B+', 'B−', 'AB+', 'AB−', 'O+', 'O−']),
            'nationality' => $faker->countryCode(),
            'country_of_birth' => $faker->countryCode(),
            // Family
            'marital_status' =>  $marital_status,
            'marriage_anniversary' => $is_married ? $faker->dateTimeBetween('1970-01-01', '2004-01-01') : null,
            'spouse_first_name' => $is_married ? $faker->firstName($opposite_gender) : null,
            'spouse_middle_name' => $is_married ? "" : null,
            'spouse_last_name' => $is_married ? $faker->lastName() : null,
            'spouse_date_of_birth' => $is_married ? $faker->dateTimeBetween('1970-01-01', '2004-01-01') : null,
            'spouse_birthday' => $is_married ? $faker->dateTimeBetween('1970-01-01', '2004-01-01') : null,
            'number_of_children' => $is_married ? $faker->numberBetween(1, 5) : null,
            // Education
            'field_of_study' => $faker->jobTitle(),
            'highest_degree' => "",
            // Identity
            'passport_number' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'uan' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'aadhaar_number' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'pan_number' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'driving_license_number' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'voter_id' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            // Contact
            'work_email' => $work_email,
            'work_phone_1' => $faker->phoneNumber(),
            'work_phone_2' => $faker->phoneNumber(),
            'present_address_line_1' => $faker->streetName(),
            'present_address_line_2' => $faker->streetAddress(),
            'present_address_city' => $faker->city(),
            'present_address_state' => $faker->state(),
            'present_address_post_code' => $faker->postcode(),
            'present_address_country' => $faker->countryCode(),
            // Personal Contact
            'personal_email' => $faker->email(),
            'personal_phone' => $faker->phoneNumber(),
            'emergency_contact_name' => $faker->name(),
            'emergency_contact_relation' => $faker->randomElement(['father', 'mother', 'brother', 'sister', 'uncle', 'aunt', 'grandfather', 'grandmother', 'other']),
            'emergency_contact_phone' => $faker->phoneNumber(),
            'permanent_address_line_1' => $faker->streetName(),
            'permanent_address_line_2' => $faker->streetAddress(),
            'permanent_address_city' => $faker->city(),
            'permanent_address_state' => $faker->state(),
            'permanent_address_post_code' => $faker->postcode(),
            'permanent_address_country' => $faker->countryCode(),
            // Financial
            'bank_account_number' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'bank_name' => $faker->company(),
            'bank_ifsc_code' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'bank_micr_code' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'bank_swift_code' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'bank_iban_code' => $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999) . $faker->numberBetween(100, 999),
            'bank_address_line_1' => $faker->streetName(),
            'bank_address_line_2' => $faker->streetAddress(),
            'bank_address_city' => $faker->city(),
            'bank_address_state' => $faker->state(),
            'bank_address_post_code' => $faker->postcode(),
            'bank_address_country' => $faker->countryCode(),
            'bank_phone' => $faker->phoneNumber(),
            'bank_email' => $faker->email(),
        ]);
    }
}
