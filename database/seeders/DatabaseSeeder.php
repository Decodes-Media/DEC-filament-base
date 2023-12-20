<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('  > Start seeding...');
        $this->command->newLine();

        $startTime = microtime(true);

        activity()->disableLogging();

        $this->call(TranslationDatabaseSeeder::class);
        $this->call(SettingDatabaseSeeder::class);
        $this->call(PermissionDatabaseSeeder::class);
        $this->call(RoleDatabaseSeeder::class);
        $this->call(AdminDatabaseSeeder::class);

        // $this->call(UserDatabaseSeeder::class);

        activity()->enableLogging();

        $endTime = round(microtime(true) - $startTime, 2);

        $this->command->info("  > ✔ OK: Took {$endTime} seconds.");
    }
}
