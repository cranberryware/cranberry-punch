<?php

namespace App\Observers;

use App\Models\Employee;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "updated" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "restored" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     *
     * @param  \App\Models\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
