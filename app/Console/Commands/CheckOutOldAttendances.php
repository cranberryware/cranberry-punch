<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\PrependsTimestamp;
use App\Models\Attendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckOutOldAttendances extends Command
{
    use PrependsTimestamp;
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
                    'check_out' => DB::raw('TIMESTAMPADD(HOUR, 9, check_in)'),
                    'check_out_ip' => "127.0.0.1",
                    'check_out_location' => "auto-checkout",
                ]);
        $this->info("Number of Records Updated: {$records_updated}");
        return Command::SUCCESS;
    }
}
