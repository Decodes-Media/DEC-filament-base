<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/laravel/laravel/blob/10.x/database/migrations/2014_10_12_000000_create_users_table.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('main_users', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->text('avatar_path')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('password_updated_at')->nullable();
            $table->string('address', 512)->nullable();
            $table->string('about', 2048)->nullable();
            $table->rememberToken();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('main_users');
    }
};
