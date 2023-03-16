<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LeaveRequestScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (app()->runningInConsole()) {
            return;
        }

        if (auth()->user()) {
            if (auth()->user()->hasRole(['hr-manager', 'super-admin'])) {
                return;
            }

            if (auth()->user()->can("view attendances")) {
                $builder->where('employee_id', auth()->user()->employee->id); // LeaveRequest Created by User
                if (auth()->user()->employee) {
                    $builder->orWhere('employee_id', auth()->user()->employee->id); // LeaveRequest of User
                }
            }
        }
    }

}
