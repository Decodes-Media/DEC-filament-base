<?php

namespace Database\Seeders\Base;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Base\Permission;
use Illuminate\Database\Seeder;

class PermissionDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $i = 0;
        foreach (config('base.permissions') as $guard => $permissions) {
            $j = 0;
            foreach ($permissions as $name) {
                Permission::create([
                    'name' => $name,
                    'guard_name' => explode(':', $guard)[1],
                    'display_order' => $i + $j / 10,
                ]);
                $j++;
            }
            $i++;
        }
    }
}
