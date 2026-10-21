<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Matches the address tables to the columns in public/uploads/sqldata/*.sql
 * so `php artisan address:import` can load the full Philippine (PSGC) dataset.
 */
return new class extends Migration
{
    private const TABLES = ['regions', 'provinces', 'cities', 'barangays'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->string('code')->nullable()->after('id');
        });

        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->nullableTimestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }

        Schema::table('provinces', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
