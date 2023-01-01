<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
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
        return $user->hasPermissionTo("viewAny attendances");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Attendance $attendance)
    {
        return $user->hasPermissionTo("view attendances");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo("create attendances");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Attendance $attendance)
    {
        return $user->hasPermissionTo("update attendances") && $user->hasRole(['hr-manager', 'super-admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Attendance $attendance)
    {
        return $user->hasPermissionTo("delete attendances") && $user->hasRole(['hr-manager', 'super-admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Attendance $attendance)
    {
        return $user->hasPermissionTo("restore attendances") && $user->hasRole(['hr-manager', 'super-admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Attendance $attendance)
    {
        return $user->hasPermissionTo("forceDelete attendances") && $user->hasRole(['hr-manager', 'super-admin']);
    }
}
