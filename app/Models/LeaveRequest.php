<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'leave_session_id',
        'status',
        'short_description',
        'reason',
        'documents',
        'notes',
        'from',
        'to',
        'duration',
        'applied_on',
        'approved_on',
        'rejected_on',
    ];

    protected $dates = [
        'from',
        'to',
        'applied_on',
        'approved_on',
        'rejected_on',
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
