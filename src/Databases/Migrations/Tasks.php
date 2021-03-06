<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Tasks
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('tasks');

        DB::schema()->create('tasks', function ($table) {
            $table->string('id', 255)->primary();
            $table->string('name', 255)->nullable();
            $table->string('projectId', 255)->nullable();
            $table->string('workspaceId', 255)->nullable();
            $table->string('assigneeId', 255)->nullable();
            $table->string('estimate', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('duration', 255)->nullable();
        });
    }
}
