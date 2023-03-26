<?php

namespace App\Models;

use App\Enums\LeaveRequestStatus;
use App\Models\Scopes\LeaveRequestScope;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'leave_session_id',
        'short_description',
        'reason',
        'documents',
        'notes',
        'from',
        'to',
        'duration',
        'approved_on',
        'rejected_on',
    ];

    protected $attributes = [
        'status' => LeaveRequestStatus::PENDING,
    ];

    protected $dates = [
        'from',
        'to',
        'applied_on',
        'approved_on',
        'rejected_on',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LeaveRequestScope);
        static::creating(function($model) {
            $model->applied_on = Carbon::now();
            $model->manager_user_id= $model->employee->manager?->user?->id ?? 1;
        });
        static::saving(function($model){
            $model->setAttribute('duration',$model->getDuration());
        });
        static::saved(function($model){
            if (!$model->isDirty('status')) return;

            if ($model->status === LeaveRequestStatus::APPROVED) {
                $model->updateLeaveBalances();
            }

        });
    }

    // function for getting time duration
    public function getDuration()
    {
        $start_date = Carbon::parse($this->from);
        $end_date = Carbon::parse($this->to);
        $duration = $start_date->diffInDays($end_date);
        return $duration;
    }

    // update leave balances
    public function updateLeaveBalances()
    {
        // leave type allowances
        $leave_allowances = Collection::make($this->leaveType->total_allowance);

        // employee designation
        $designation = $this->employee->designation->name;

        // get leave allowances for the designations
        $designation_leave_allowances = $leave_allowances->where('designation', $designation);

        // if leave allowances available for designations then we use that otherwise we go with default allowance limit
        $employee_leave_allowances = $designation_leave_allowances->isNotEmpty() ? $designation_leave_allowances->pluck('number_of_allowance')->first() : $this->leaveType->default_allowance_limit;

        //Now check and update leave balances
        $leave_balance = LeaveBalance::updateOrCreate([
            'employee_id' => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'leave_session_id' => $this->leave_session_id
        ], [
            'used' => DB::raw('used + ' . $this->duration),
            'available' => DB::raw('available - ' . $this->duration + $employee_leave_allowances)
        ]);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    // manager_id is a user_id
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_user_id');
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
