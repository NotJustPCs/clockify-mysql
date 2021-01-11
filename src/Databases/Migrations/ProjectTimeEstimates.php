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
        DB::schema()->dropIfExists('clockify_project_time_estimates');

        DB::schema()->create('clockify_project_time_estimates', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('projectId', 255)->nullable();
            $table->string('estimate', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('resetOption', 255)->nullable();
            $table->boolean('active')->nullable();
        });
    }
}
