<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view-dashboard',
            'view-docs',
            'manage-admins',
            'manage-applications',
            'manage-plans',
            'manage-blasku-landing',
            'manage-serials',
            'manage-licenses',
            'manage-devices',
        ];

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }

        $superAdmin = Role::query()->firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);
        $opsAdmin = Role::query()->firstOrCreate([
            'name' => 'ops_admin',
            'guard_name' => 'admin',
        ]);

        $superAdmin->syncPermissions($permissions);
        $opsAdmin->syncPermissions([
            'view-dashboard',
            'view-docs',
            'manage-applications',
            'manage-plans',
            'manage-blasku-landing',
            'manage-serials',
            'manage-licenses',
            'manage-devices',
        ]);

        $admin = Admin::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin12345'),
                'is_active' => true,
            ]
        );
        $admin->assignRole('super_admin');
    }
}
