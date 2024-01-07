<?php

namespace Database\Seeders\Base;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TranslationDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Execute sync translations from kenepa/translation-manager
        Artisan::call('translations:synchronize');
    }
}
