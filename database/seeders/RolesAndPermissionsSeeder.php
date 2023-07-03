<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $policies = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];
        $models = ['attendances', 'employees', 'departments', 'designations', 'users', 'permissions', 'roles', 'leaveRequests'];
        foreach ($policies as $policy) {
            foreach ($models as $model) {
                Permission::create([
                    'name' => "{$policy} {$model}",
                    'guard_name' => "web",
                ]);
            }
        }

        Permission::create([
            'name' => "manage settings",
            'guard_name' => "web",
        ]);

        Permission::create([
            'name' => "manage attendance settings",
            'guard_name' => "web",
        ]);

        Permission::create([
            'name' => "clock attendances",
            'guard_name' => "web",
        ]);

        // this can be done as separate statements
        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'hr-manager'])
            ->givePermissionTo([
                'viewAny attendances',
                'view attendances',
                'create attendances',
                'update attendances',
                'delete attendances',
                'viewAny employees',
                'view employees',
                'create employees',
                'update employees',
                'delete employees',
                'viewAny departments',
                'view departments',
                'create departments',
                'update departments',
                'delete departments',
                'viewAny designations',
                'view designations',
                'create designations',
                'update departments',
                'delete departments',
                'viewAny leaveRequests',
                'view leaveRequests',
                'create leaveRequests',
                'update leaveRequests',
                'manage attendance settings',
            ]);

        Role::create(['name' => 'employee'])
            ->givePermissionTo([
                'viewAny attendances',
                'view attendances',
                'clock attendances',
                'viewAny leaveRequests',
                'view leaveRequests',
                'create leaveRequests',
                'update leaveRequests',
                // 'create attendances',
                // 'viewAny departments',
                // 'viewAny designations',
            ]);
    }
}
