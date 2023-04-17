<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Define the names of the permissions
        $permissionNames = [
            'viewAny leaveRequests',
            'view leaveRequests',
            'create leaveRequests',
            'update leaveRequests',
        ];

        // Create the permissions in the database
        foreach ($permissionNames as $name) {
            $permission = Permission::where('name', $name)->first();

            if (!$permission) {
                Permission::create(['name' => $name]);
            }
        }

        // Assign the permissions to the employee role
        $employeeRole = Role::findOrCreate('employee');
        $employeeRole->givePermissionTo($permissionNames);

        // Assign the permissions to the hr-manager role
        $hrManagerRole = Role::findOrCreate('hr-manager');
        $hrManagerRole->givePermissionTo($permissionNames);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $employeeRole = Role::findByName('employee');
        $employeeRole->revokePermissionTo([
            'viewAny leaveRequests',
            'view leaveRequests',
            'create leaveRequests',
            'update leaveRequests',
        ]);

        $hrManagerRole = Role::findByName('hr-manager');
        $hrManagerRole->revokePermissionTo([
            'viewAny leaveRequests',
            'view leaveRequests',
            'create leaveRequests',
            'update leaveRequests',
        ]);
    }
};
