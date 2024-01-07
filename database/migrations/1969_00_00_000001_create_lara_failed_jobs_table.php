<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Queue/Console/stubs/failed_jobs.stub
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('queue.failed.table'), function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('queue.failed.table'));
    }
};
