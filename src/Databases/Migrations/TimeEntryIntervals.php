<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class TimeEntryIntervals
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_time_entry_intervals');

        DB::schema()->create('clockify_time_entry_intervals', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('workspaceId', 255);
            $table->string('userId', 255)->nullable();
            $table->string('projectId', 255)->nullable();
            $table->string('timeEntryId', 255)->nullable();
            $table->string('start', 255)->nullable();
            $table->string('end', 255)->nullable();
            $table->string('duration', 255)->nullable();
        });
    }
}
