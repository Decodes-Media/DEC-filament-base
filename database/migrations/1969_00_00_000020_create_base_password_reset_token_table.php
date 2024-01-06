<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/laravel/laravel/blob/10.x/database/migrations/2014_10_12_100000_create_password_reset_tokens_table.php
 *
 * - Added type column
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('type')->nullable();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base_password_reset_tokens');
    }
};
