<?php


namespace JDecool\Clockify\Databases\Migrations;

use Illuminate\Database\Capsule\Manager as DB;

class Tags
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clockify_tags');

        DB::schema()->create('clockify_tags', function ($table) {
            $table->string('id', 255)->primary();
            $table->string('name', 255)->nullable();
            $table->string('workspaceId', 255)->nullable();
            $table->string('archived', 255)->nullable();
        });
    }
}
