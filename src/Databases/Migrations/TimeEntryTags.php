<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class TimeEntryTags
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('time_entry_tags');

        DB::schema()->create('time_entry_tags', function ($table) {
            $table->string('workspaceId', 255);
            $table->string('userId', 255)->nullable();
            $table->string('projectId', 255)->nullable();
            $table->string('timeEntryId', 255)->nullable();
            $table->string('tagId', 255)->nullable();
        });
    }
}
