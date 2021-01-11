<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class TaskAssignees
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_task_assignees');

        DB::schema()->create('clockify_task_assignees', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('workspaceId', 255);
            $table->string('projectId', 255)->nullable();
            $table->string('assigneeId', 255)->nullable();
        });
    }
}
