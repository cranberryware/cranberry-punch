<?php

namespace App\Models;

use App\Models\Scopes\AttendanceScope;
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
    ];

    protected static function booted()
    {
        static::addGlobalScope(new AttendanceScope);
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
}
