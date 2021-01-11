<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceMembershipHourlyRates
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_workspace_membership_hourly_rates');

        DB::schema()->create('clockify_workspace_membership_hourly_rates', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('workspaceId', 255);
            $table->string('userId', 255)->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency', 255)->nullable();
        });
    }
}
