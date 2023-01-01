<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use BladeUI\Icons\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_designations = [
            [
                'name' => 'Director',
            ],
            [
                'name' => 'Vice President'
            ],
            [
                'name' => 'Associate Vice President'
            ],
            [
                'name' => 'Senior Manager'
            ],
            [
                'name' => 'Manager'
            ],
            [
                'name' => 'Assistant Manager'
            ],
            [
                'name' => 'Junior Manager'
            ],
            [
                'name' => 'Associate'
            ],
            [
                'name' => 'Executive'
            ],
        ];
        $default_departments = [
            [
                'name' => 'Administration',
                'description' => 'Administration department',
            ],
            [
                'name' => 'Content Creation',
                'description' => 'Content Creation department',
            ],
            [
                'name' => 'Design and Graphics',
                'description' => 'Design and Graphics department',
            ],
            [
                'name' => 'Finance and Accounting',
                'description' => 'Finance and Accounting department',
            ],
            [
                'name' => 'Human Resources',
                'description' => 'Human Resources department',
            ],
            [
                'name' => 'IT and Infrastructure',
                'description' => 'IT and Infrastructure department',
            ],
            [
                'name' => 'Management',
                'description' => 'Management',
            ],
            [
                'name' => 'Sales and Marketing',
                'description' => 'Sales and Marketing department',
            ],
            [
                'name' => 'Technology',
                'description' => 'Technology department',
            ]
        ];
        foreach ($default_departments as $default_department) {
            $department = Department::create($default_department);
            foreach ($default_designations as $designation) {
                $designation['name'] = "{$designation['name']}, {$department['name']}";
                $department->designations()->save(Designation::create($designation));
            }
        }
    }
}
