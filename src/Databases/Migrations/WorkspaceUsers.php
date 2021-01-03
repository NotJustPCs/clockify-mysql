<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceUsers
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_workspace_users');

        DB::schema()->create('clockify_workspace_users', function ($table) {
            $table->string('id', 255);
            $table->string('workspaceId', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('profilePicture', 255)->nullable();
            $table->string('activeWorkspace', 255)->nullable();
            $table->string('defaultWorkspace', 255)->nullable();
            $table->string('status', 255)->nullable();
        });
    }
}
