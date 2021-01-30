<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class ProjectCostRate
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('project_cost_rate');

        DB::schema()->create('project_cost_rate', function ($table) {
            $table->string('projectId', 255);
            $table->integer('amount')->nullable();
            $table->string('currency', 255)->nullable();
        });
    }
}
