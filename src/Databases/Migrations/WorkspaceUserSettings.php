<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceUserSettings
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_workspace_user_settings');

        DB::schema()->create('clockify_workspace_user_settings', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('workspaceId', 255);
            $table->string('userId', 255);
            $table->string('weekStart', 255)->nullable();
            $table->string('timeZone', 255)->nullable();
            $table->string('timeFormat', 255)->nullable();
            $table->string('dateFormat', 255)->nullable();
            $table->boolean('sendNewsletter')->nullable();
            $table->boolean('weeklyUpdates')->nullable();
            $table->boolean('longRunning')->nullable();
            $table->boolean('timeTrackingManual')->nullable();
            $table->boolean('isCompactViewOn')->nullable();
            $table->string('dashboardSelection', 255)->nullable();
            $table->string('dashboardViewType', 255)->nullable();
            $table->boolean('dashboardPinToTop')->nullable();
            $table->string('projectListCollapse', 255)->nullable();
            $table->boolean('collapseAllProjectLists')->nullable();
            $table->boolean('groupSimilarEntriesDisabled')->nullable();
            $table->string('myStartOfDay', 255)->nullable();
        });
    }
}
