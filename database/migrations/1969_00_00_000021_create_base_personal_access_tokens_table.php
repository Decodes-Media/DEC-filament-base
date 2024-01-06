<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/laravel/laravel/blob/10.x/database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php
 *
 * - Updated morphs to ulidMorphs
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_personal_access_tokens', function (Blueprint $table) {
            $table->id();
            // $table->morphs('tokenable');
            $table->ulidMorphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base_personal_access_tokens');
    }
};
