<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Projects
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_projects');

        DB::schema()->create('clockify_projects', function ($table) {
            $table->engine = $config['db_engine'];
            $table->string('id', 255)->primary();
            $table->string('name', 255)->nullable();
            $table->string('workspaceId', 255)->nullable();
            $table->string('clientId', 255)->nullable();
            $table->boolean('billable')->nullable();
            $table->string('color', 255)->nullable();
            $table->boolean('archived')->nullable();
            $table->string('duration', 255)->nullable();
            $table->string('clientName', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->string('costRate', 255)->nullable();
            $table->string('budgetEstimate', 255)->nullable();
            $table->boolean('template')->nullable();
            $table->boolean('public')->nullable();
        });
    }
}
