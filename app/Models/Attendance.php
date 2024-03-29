<?php

namespace App\Models;

use App\Models\Scopes\AttendanceScope;
use App\Settings\AttendanceSettings;
use App\Support\Utility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Attendance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RevisionableTrait;

    protected $appends = ['worked_hours_rounded'];

    public function getWorkedHoursRoundedAttribute()
    {
        return round($this->worked_hours, 2);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'user_id',
        'check_in',
        'check_out',
        'check_in_ip',
        'check_in_location',
        'check_in_device_id',
        'check_out_ip',
        'check_out_location',
        'check_out_device_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AttendanceScope);
        static::saving(function ($model) {
            if ($model->isDirty('check_in')) {
                $model->setAttribute('check_in_ip', request()->ip());
                $model->setAttribute('check_in_location', Utility::get_location_from_ip(request()->ip()));
            }
            if ($model->isDirty('check_out')) {
                $model->setAttribute('check_out_ip', request()->ip());
                $model->setAttribute('check_out_location', Utility::get_location_from_ip(request()->ip()));
            }
        });
    }

    /**
     * > The employee() function returns the Employee model that is related to the current Employee model
     *
     * @return The employee for the attendance.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * > This function returns the user that owns the attendance
     *
     * @return The user that created the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public static function isWorkingDay($date)
    // {
    //     $date = is_a($date, Carbon::class) ? $date : Carbon::parse($date);

    // }

    /**
     * Get the check-in device associated with the attendance.
     */
    public function checkInDevice()
    {
        return $this->belongsTo(ClockingDevice::class, 'check_in_device_id');
    }

    /**
     * Get the check-out device associated with the attendance.
     */
    public function checkOutDevice()
    {
        return $this->belongsTo(ClockingDevice::class, 'check_out_device_id');
    }

    /**
     * Get the check-in device name associated with the attendance.
     *
     * @return string|null
     */
    public function getCheckInDeviceNameAttribute()
    {
        return $this->checkInDevice ? $this->checkInDevice->device_name : null;
    }

    /**
     * Get the check-in device name associated with the attendance.
     *
     * @return string|null
     */
    public function getCheckOutDeviceNameAttribute()
    {
        return $this->checkOutDevice ? $this->checkOutDevice->device_name : null;
    }
}
