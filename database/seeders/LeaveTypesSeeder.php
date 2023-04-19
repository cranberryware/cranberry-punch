<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use App\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Annual Leave',
                'description' => 'Annual leave is a paid time off work granted by employers to employees to be used for whatever the employee wishes.',
                'default_allowance_limit' => 30,
                'default_claim_allowance_limit' => 20,
                'notify_before' => 14
            ],
            [
                'name' => 'Sick Leave',
                'description' => 'Sick leave is a paid time off work granted by employers to employees who are unable to work due to illness or injury.',
                'default_allowance_limit' => 15,
                'default_claim_allowance_limit' => 10,
                'notify_before' => 7
            ],
            [
                'name' => 'Maternity Leave',
                'description' => 'Maternity leave is a period of absence from work granted to new mothers for the purpose of giving birth, or for the adoption of a child.',
                'default_allowance_limit' => 90,
                'default_claim_allowance_limit' => 60,
                'notify_before' => 30
            ],
            [
                'name' => 'Paternity Leave',
                'description' => 'Paternity leave is a period of absence from work granted to new fathers for the purpose of caring for a new child.',
                'default_allowance_limit' => 10,
                'default_claim_allowance_limit' => 5,
                'notify_before' => 7
            ],
            [
                'name' => 'Bereavement Leave',
                'description' => 'Bereavement leave is a period of absence from work granted to employees who have suffered a death in their immediate family or household.',
                'default_allowance_limit' => 5,
                'default_claim_allowance_limit' => 3,
                'notify_before' => 2
            ],
            [
                'name' => 'Jury Duty Leave',
                'description' => 'Jury duty leave is a period of absence from work granted to employees who are serving on a jury.',
                'default_allowance_limit' => 10,
                'default_claim_allowance_limit' => 5,
                'notify_before' => 7
            ],
            [
                'name' => 'Compassionate Leave',
                'description' => 'Compassionate leave is a period of absence from work granted to employees who need to care for a seriously ill family member or attend a funeral.',
                'default_allowance_limit' => 5,
                'default_claim_allowance_limit' => 3,
                'notify_before' => 2
            ],
        ];

        foreach ($types as $type) {
            LeaveType::create([
                'name' => $type['name'],
                'slug' => Str::slug($type['name']),
                'description' => $type['description'],
                'total_allowance' => [],
                'default_allowance_limit' => $type['default_allowance_limit'],
                'default_claim_allowance_limit' => $type['default_claim_allowance_limit'],
                'notify_before' => $type['notify_before'],
            ]);
        }
    }
}
