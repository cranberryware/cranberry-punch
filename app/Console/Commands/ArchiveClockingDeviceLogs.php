<?php

namespace App\Console\Commands;

use App\Models\ClockingDeviceLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\DbDumper\Databases\MySql;

class ArchiveClockingDeviceLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cp:archive-clocking-device-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Dumps and Archives Clocking Device Logs into Storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::makeDirectory(storage_path("dumps"), 0755, true, true);
        $dump_file_name = "dump-clocking_device_logs.".\Carbon\Carbon::now()->format('Y-m-d_H_i_s').".sql";
        $dump_file_path = storage_path("dumps/{$dump_file_name}");
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->setHost(config('database.connections.mysql.host'))
            ->setPort(config('database.connections.mysql.port'))
            ->addExtraOption('--no-create-info --skip-add-drop-table')
            ->includeTables(['clocking_device_logs'])
            ->dumpToFile($dump_file_path);
        ClockingDeviceLog::query()->truncate();
        $gzipping = `gzip {$dump_file_path}`;
        $this->info("Archiving 'clocking_device_logs' at '{$dump_file_path}.gz'");
        return Command::SUCCESS;
    }
}
