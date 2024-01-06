<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\App\Admin;
use App\Models\Base\Setting;
use Illuminate\Database\Seeder;

class AdminDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $super = Admin::factory()->create([
            'name' => 'Superadmin',
            'email' => config('base.superadmin_email'),
        ]);

        $super->assignRole('Superadmin');

        Setting::set("admin.{$super->id}.lorem'", 'ipsum', true);

        $admin = Admin::factory()->create([
            'name' => 'Admin',
        ]);

        $admin->assignRole('Admin');
    }
}
