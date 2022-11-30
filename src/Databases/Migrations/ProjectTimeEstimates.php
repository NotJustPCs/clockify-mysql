<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class ProjectTimeEstimates
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('project_time_estimates');

        DB::schema()->create('project_time_estimates', function ($table) {
            $table->string('projectId', 255)->nullable();
            $table->string('estimate', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('resetOption', 255)->nullable();
            $table->boolean('active')->nullable();
			$table->boolean('includeNonBillable')->nullable();
        });
    }
}
