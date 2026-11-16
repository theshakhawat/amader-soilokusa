<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds with comprehensive granular permissions.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = config('permission_modules.modules', []);

        $allPermissionNames = [];
        foreach ($modules as $modKey => $module) {
            foreach ($module['permissions'] as $permName => $permInfo) {
                $allPermissionNames[] = $permName;
                Permission::firstOrCreate([
                    'name'       => $permName,
                    'guard_name' => 'web',
                ]);
            }
        }

        // 1. Super Admin Role (All Permissions)
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin Role (All Permissions - Full Access to Everything)
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        // 3. Manager Role (Example Manager with Content + Management but no Deletions)
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $managerPermissions = array_filter($allPermissionNames, function ($name) {
            return !str_ends_with($name, '.delete') && $name !== 'roles.manage';
        });
        $manager->syncPermissions($managerPermissions);

        // 4. Normal Member Role (Default Basic Access)
        $member = Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);
        // Members don't have admin portal access by default
        $member->syncPermissions([]);
    }
}
