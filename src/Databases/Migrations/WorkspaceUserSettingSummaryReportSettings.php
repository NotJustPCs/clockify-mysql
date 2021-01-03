<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceUserSettingSummaryReportSettings
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_workspace_user_setting_summary_report_settings');
        DB::schema()->create('clockify_workspace_user_setting_summary_report_settings', function ($table) {
            $table->string('userId', 255);
            $table->string('workspaceId', 255)->nullable();
            $table->string('group', 255)->nullable();
            $table->string('subgroup', 255)->nullable();
        });
    }
}
