<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see https://github.com/spatie/laravel-activitylog/tree/main/database/migrations
 *
 * - Merged all migrations to one
 * - Updated unsignedBigInteger to ulid
 * - Updated morphs to ulidMorphs
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->up__create_activity_log_table();
        $this->up__add_event_column_to_activity_log_table();
        $this->up__add_batch_uuid_column_to_activity_log_table();
    }

    public function down(): void
    {
        $this->down__add_batch_uuid_column_to_activity_log_table();
        $this->down__add_event_column_to_activity_log_table();
        $this->down__create_activity_log_table();
    }

    public function up__create_activity_log_table(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->create(config('activitylog.table_name'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('log_name')->nullable();
                $table->text('description');
                // $table->nullableMorphs('subject', 'subject');
                // $table->nullableMorphs('causer', 'causer');
                $table->nullableUlidMorphs('subject', 'subject');
                $table->nullableUlidMorphs('causer', 'causer');
                $table->json('properties')->nullable();
                $table->timestamps();
                $table->index('log_name');
            });
    }

    public function down__create_activity_log_table(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->dropIfExists(config('activitylog.table_name'));
    }

    public function up__add_event_column_to_activity_log_table(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->table(config('activitylog.table_name'), function (Blueprint $table) {
                $table->string('event')->nullable()->after('subject_type');
            });
    }

    public function down__add_event_column_to_activity_log_table(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->table(config('activitylog.table_name'), function (Blueprint $table) {
                $table->dropColumn('event');
            });
    }

    public function up__add_batch_uuid_column_to_activity_log_table(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->table(config('activitylog.table_name'), function (Blueprint $table) {
                $table->uuid('batch_uuid')->nullable()->after('properties');
            });
    }

    public function down__add_batch_uuid_column_to_activity_log_table(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->table(config('activitylog.table_name'), function (Blueprint $table) {
                $table->dropColumn('batch_uuid');
            });
    }
};
