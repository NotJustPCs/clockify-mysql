<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceSettings
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_workspace_settings');

        DB::schema()->create('clockify_workspace_settings', function ($table) {
            $table->string('workspaceId', 255);
            $table->boolean('timeRoundingInReports')->nullable();
            $table->boolean('onlyAdminsSeeBillableRates')->nullable();
            $table->boolean('onlyAdminsCreateProject')->nullable();
            $table->boolean('onlyAdminsSeeDashboard')->nullable();
            $table->boolean('defaultBillableProjects')->nullable();
            $table->string('lockTimeEntries', 255)->nullable();
            $table->boolean('projectFavorites')->nullable();
            $table->boolean('canSeeTimeSheet')->nullable();
            $table->boolean('canSeeTracker')->nullable();
            $table->boolean('projectPickerSpecialFilter')->nullable();
            $table->boolean('forceProjects')->nullable();
            $table->boolean('forceTasks')->nullable();
            $table->boolean('forceTags')->nullable();
            $table->boolean('forceDescription')->nullable();
            $table->boolean('onlyAdminsSeeAllTimeEntries')->nullable();
            $table->boolean('onlyAdminsSeePublicProjectsEntries')->nullable();
            $table->boolean('trackTimeDownToSecond')->nullable();
            $table->string('projectGroupingLabel', 255)->nullable();
            $table->string('automaticLock', 255)->nullable();
            $table->boolean('onlyAdminsCreateTag')->nullable();
            $table->boolean('onlyAdminsCreateTask')->nullable();
            $table->string('timeTrackingMode', 255)->nullable();
            $table->boolean('isProjectPublicByDefault')->nullable();
        });
    }
}
