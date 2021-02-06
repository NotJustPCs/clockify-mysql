<?php


namespace JDecool\Clockify\Databases\Migrations;


use Illuminate\Database\Capsule\Manager as DB;

class Clients
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public static function up()
    {
        DB::schema()->dropIfExists('clients');

        DB::schema()->create('clients', function ($table) {
            $table->string('id', 255)->primary();
            $table->string('name', 255)->nullable();
            $table->string('workspaceId', 255)->nullable();
            $table->string('archived', 255)->nullable();
            $table->string('address', 255)->nullable();
        });
    }
}
