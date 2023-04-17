<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveBalance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RevisionableTrait;

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'leave_session_id',
        'used',
        'available',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function leaveSession()
    {
        return $this->belongsTo(LeaveSession::class);
    }
}
