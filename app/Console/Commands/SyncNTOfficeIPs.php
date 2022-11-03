<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\PrependsTimestamp;
use App\Settings\AttendanceSettings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncNTOfficeIPs extends Command
{
    use PrependsTimestamp;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oa:sync-nt-office-ips';

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
        $response = Http::get("https://ga-430.nettantra.com:81/check-network-JFXX45RMsujsndxb0O20xVpC.php?mode=text");
        $ips_list = preg_replace(['/enp[\d]s0: ([^:]+)?/', '/: (.*) :.*/'], ['', '$1'], $response);
        $ips_list = explode(PHP_EOL, $ips_list);
        $ips_list = array_filter($ips_list);
        print_r($ips_list);
        $ips_list = array_map(function ($ip) {
            $ip_parts = explode(".", $ip);
            $ip_parts = array_map(function ($ip_part) {
                return ltrim($ip_part, "0");
            }, $ip_parts);
            return join(".", $ip_parts);
        }, $ips_list);
        $existing_ip_locations = app(AttendanceSettings::class)->ip_locations;
        $new_ip_locations = array_filter($existing_ip_locations, function ($value) {
            return $value['location'] != "nt-office";
        });
        foreach($ips_list as $nt_office_ip) {
            $new_ip_locations[] = [
                'ip' => $nt_office_ip,
                'location' => "nt-office"
            ];
        }
        $attendance_settings = app(AttendanceSettings::class);
        $attendance_settings->ip_locations = $new_ip_locations;
        $attendance_settings->save();
        $ips_list_str = join(", ", $ips_list);
        $this->info("NT Office IPs {$ips_list_str} have been updated successfully");
        return Command::SUCCESS;
    }
}
