<?php

namespace App\Support;

use App\Settings\AttendanceSettings;

class Utility {
    public static function get_location_from_ip($ip)
    {
        $ip_locations = app(AttendanceSettings::class)->ip_locations;
        $location = "-";
        foreach($ip_locations as $key => $ip_location) {
            if($ip_location['ip'] == $ip) {
                $location = $ip_location['location'];
            }
        }
        return $location;
    }
}
