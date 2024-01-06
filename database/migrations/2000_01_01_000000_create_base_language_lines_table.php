<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/spatie/laravel-translation-loader/blob/main/database/migrations/create_language_lines_table.php.stub
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_language_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group')->index();
            $table->string('key');
            $table->json('text')->default(new \Illuminate\Database\Query\Expression('(JSON_ARRAY())'));
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base_language_lines');
    }
};
