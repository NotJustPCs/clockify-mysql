<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceUserMemberships
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('workspace_user_memberships');

        DB::schema()->create('workspace_user_memberships', function ($table) {
            $table->string('workspaceId', 255);
            $table->string('userId', 255)->nullable();
            $table->string('costRate', 255)->nullable();
            $table->string('targetId', 255)->nullable();
            $table->string('membershipType', 255)->nullable();
            $table->string('membershipStatus', 255)->nullable();
        });
    }
}
