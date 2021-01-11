<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceMemberships
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_workspace_memberships');

        DB::schema()->create('clockify_workspace_memberships', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('workspaceId', 255);
            $table->string('userId', 255)->nullable();
            $table->string('costRate')->nullable();
            $table->string('targetId')->nullable();
            $table->string('membershipType')->nullable();
            $table->string('membershipStatus')->nullable();
        });
    }
}
