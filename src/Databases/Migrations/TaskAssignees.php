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
        DB::schema()->dropIfExists('task_assignees');

        DB::schema()->create('task_assignees', function ($table) {
            $table->string('taskId', 255);
            $table->string('assigneeId', 255)->nullable();
        });
    }
}
