<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceAdminOnlyPages
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('workspace_admin_only_pages');

        DB::schema()->create('workspace_admin_only_pages', function ($table) {
            $table->string('workspaceId', 255);
            $table->string('adminOnlyPages', 255)->nullable();
        });
    }
}
