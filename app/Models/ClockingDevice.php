<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClockingDevice extends Model
{
    use HasFactory;

    protected $fillable=[
        'device_name',
        'device_location',
        'device_serial',
        'device_identifier',
        'device_status',
        'device_mode',
        'emp_prefix',
        'device_secret',
        'device_timezone',
    ];
}
