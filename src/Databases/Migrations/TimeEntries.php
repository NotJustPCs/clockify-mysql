<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class TimeEntries
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_time_entries');

        DB::schema()->create('clockify_time_entries', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('id', 255)->primary();
            $table->string('description', 255)->nullable();
            $table->string('userId', 255)->nullable();
            $table->boolean('billable')->nullable();
            $table->string('taskId', 255)->nullable();
            $table->string('projectId', 255)->nullable();
            $table->string('workspaceId', 255)->nullable();
            $table->boolean('isLocked')->nullable();
            $table->string('customFieldValues', 255)->nullable();
        });
    }
}
