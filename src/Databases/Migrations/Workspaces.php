<?php

namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Workspaces
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('workspaces');

        DB::schema()->create('workspaces', function ($table) {
            $table->string('id', 255)->primary();
            $table->string('name', 255)->nullable();
            $table->string('imageUrl', 255)->nullable();
            $table->string('featureSubscriptionType', 255)->nullable();
        });
    }
}
