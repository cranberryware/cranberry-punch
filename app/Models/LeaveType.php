<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use RevisionableTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'total_allowance',
        'default_allowance_limit',
        'default_claim_allowance_limit',
        'notify_before',
    ];

    protected $casts = [
        'total_allowance' => 'array',
    ];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
