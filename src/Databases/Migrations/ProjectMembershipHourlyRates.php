<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class ProjectMembershipHourlyRates
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_project_membership_hourly_rates');

        DB::schema()->create('clockify_project_membership_hourly_rates', function ($table) {
            $table->string('projectId', 255);
            $table->string('userId', 255)->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency', 255)->nullable();
        });
    }
}
