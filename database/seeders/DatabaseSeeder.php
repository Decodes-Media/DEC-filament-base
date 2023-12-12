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

        $this->call(BaseDatabaseSeeder::class);
        $this->call(LangDatabaseSeeder::class);
        $this->call(MasterDatabaseSeeder::class);

        $endTime = round(microtime(true) - $startTime, 2);

        $this->command->info("  > ✔ OK: Took {$endTime} seconds.");
    }
}
