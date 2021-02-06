<?php

namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceSettingsRounds
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('workspace_settings_rounds');

        DB::schema()->create('workspace_settings_rounds', function ($table) {
            $table->string('workspaceId', 255);
            $table->string('round', 255)->nullable();
            $table->integer('minutes')->nullable();
        });
    }
}
