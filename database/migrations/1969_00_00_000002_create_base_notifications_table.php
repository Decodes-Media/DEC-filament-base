<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Notifications/Console/stubs/notifications.stub
 *
 * - Updated morphs to ulidMorphs
 * - Added archived_at column
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            // $table->morphs('notifiable');
            $table->ulidMorphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('base_notifications');
    }
};
