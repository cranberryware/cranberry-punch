<?php

namespace App\Policies;

use App\Enums\LeaveRequestStatus;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeaveRequestPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo("viewAny leaveRequests");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LeaveRequest $leaveRequest)
    {
        return $user->hasPermissionTo("view leaveRequests") && ($user->hasRole(['hr-manager', 'super-admin']) || $leaveRequest->employee->user->id === auth()->user()->id || ($leaveRequest->manager_user_id === auth()->user()->id && $leaveRequest->status != LeaveRequestStatus::CANCELLED));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // return true;
        return $user->hasPermissionTo("create leaveRequests");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LeaveRequest $leaveRequest)
    {
        return $user->hasPermissionTo("update leaveRequests") && ($user->hasRole(['hr-manager', 'super-admin']) || ($leaveRequest->employee->user->id === auth()->user()->id && $leaveRequest->status === LeaveRequestStatus::PENDING) || ($leaveRequest->manager_user_id === auth()->user()->id && $leaveRequest->status === LeaveRequestStatus::PENDING));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LeaveRequest $leaveRequest)
    {
        return $user->hasPermissionTo("delete leaveRequests") && $user->hasRole(['hr-manager', 'super-admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LeaveRequest $leaveRequest)
    {
        return $user->hasPermissionTo("restore leaveRequests") && $user->hasRole(['hr-manager', 'super-admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeaveRequest  $leaveRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LeaveRequest $leaveRequest)
    {
        return $user->hasPermissionTo("forceDelete leaveRequests") && $user->hasRole(['hr-manager', 'super-admin']);
    }
}
