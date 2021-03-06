<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class ProjectHourlyRates
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('project_hourly_rates');

        DB::schema()->create('project_hourly_rates', function ($table) {
            $table->string('projectId', 255);
            $table->integer('amount')->nullable();
            $table->string('currency', 255)->nullable();
        });
    }
}
