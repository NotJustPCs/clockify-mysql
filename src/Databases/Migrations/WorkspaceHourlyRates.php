<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class WorkspaceHourlyRates
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('workspace_hourly_rates');

        DB::schema()->create('workspace_hourly_rates', function ($table) {
            $table->string('workspaceId', 255);
            $table->integer('amount')->nullable();
            $table->string('currency', 255)->nullable();
        });
    }
}
