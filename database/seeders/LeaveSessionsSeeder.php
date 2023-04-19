<?php

namespace Database\Seeders;

use App\Models\LeaveSession;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveSessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $now = Carbon::now();
        for ($i = 0; $i < 5; $i++) {
            $from = $now->copy()->addYears($i)->startOfYear()->subDay();
            $to = $now->copy()->addYears($i + 1)->startOfYear()->subDay();
            LeaveSession::create([
                'title' => 'Annual Leave Session ' . $from->format('Y') . '-' . $to->format('y'),
                'description' => 'This leave session covers the annual leave entitlements for the ' . $from->format('Y') . '-' . $to->format('y') . ' fiscal year.',
                'from' => $from,
                'to' => $to,
                'status' => 'active'
            ]);
        }
    }
}
