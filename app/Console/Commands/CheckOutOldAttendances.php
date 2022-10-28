<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckOutOldAttendances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oa:check-out-old-attendances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records_updated = Attendance::where('check_out', null)
                ->where('check_in', '<', DB::raw('CURDATE()'))
                ->update([
                    'check_out' => DB::raw('TIMESTAMPADD(HOUR, 9, check_in)')
                ]);
        $this->info("Number of Records Updated: {$records_updated}");
        return Command::SUCCESS;
    }
}
