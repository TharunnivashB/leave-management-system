<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'request leave']);
        Permission::firstOrCreate(['name' => 'approve leave']);
        Permission::firstOrCreate(['name' => 'view all leaves']);
        Permission::firstOrCreate(['name' => 'generate reports']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(['approve leave', 'view all leaves', 'generate reports']);

        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->syncPermissions(['request leave']);


        $adminUser = User::where('email', 'vijaytharun658+admin@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }

        $employeeUser = User::where('email', 'vijaytharun658+employee@gmail.com')->first();
        if ($employeeUser) {
            $employeeUser->assignRole($employeeRole);
        }
    }
}
