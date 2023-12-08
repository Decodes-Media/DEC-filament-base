<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Base\Admin;
use App\Models\Base\Permission;
use App\Models\Base\Role;
use Illuminate\Database\Seeder;

class BaseDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPermissions();
        $this->seedRoles();
        $this->seedRolePermissions();
        $this->seedUsersAndAssignRoles();
    }

    protected function seedPermissions(): void
    {
        $i = 0;
        foreach (config('base.permissions') as $guard => $permissions) {
            $j = 0;
            foreach ($permissions as $name => $description) {
                Permission::create([
                    'name' => $name,
                    'guard_name' => $guard,
                    'description' => $description,
                    'display_order' => $i + $j / 10,
                ]);
                $j++;
            }
            $i++;
        }
    }

    protected function seedRoles(): void
    {
        $i = 0;
        foreach (config('base.roles') as $guard => $roles) {
            $j = 0;
            foreach ($roles as $name => $description) {
                Role::create([
                    'name' => $name,
                    'guard_name' => $guard,
                    'description' => $description,
                    'display_order' => $i + $j / 10,
                ]);
                $j++;
            }
            $i++;
        }
    }

    protected function seedRolePermissions(): void
    {
        foreach (config('base.role_permissions') as $guard => $data) {
            foreach ($data as $role => $permissions) {
                Role::findByName($role, $guard)
                    ->givePermissionTo($permissions);
            }
        }
    }

    protected function seedUsersAndAssignRoles(): void
    {
        $super = Admin::factory()->create([
            'name' => 'Superadmin',
            'email' => config('base.superadmin_email'),
        ]);

        $super->assignRole('Superadmin');

        $admin = Admin::factory()->create([
            'name' => 'Admin',
        ]);

        $admin->assignRole('Admin');
    }
}
