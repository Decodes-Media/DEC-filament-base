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

        $this->call(Base\TranslationDatabaseSeeder::class);
        $this->call(Base\SettingDatabaseSeeder::class);
        $this->call(Base\PermissionDatabaseSeeder::class);
        $this->call(Base\RoleDatabaseSeeder::class);
        $this->call(Main\AdminDatabaseSeeder::class);
        $this->call(Main\MasterDatabaseSeeder::class);

        activity()->enableLogging();

        $endTime = round(microtime(true) - $startTime, 2);

        $this->command->info("  > ✔ OK: Took {$endTime} seconds.");
    }
}
