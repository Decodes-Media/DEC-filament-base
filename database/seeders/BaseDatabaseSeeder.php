<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class BaseDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $super = Admin::factory()->create([
            'name' => 'Superadmin',
            'email' => config('base.superadmin_email'),
        ]);

        // $super->assignRole('Superadmin');
    }
}
