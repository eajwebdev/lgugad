<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Philippine address reference data (region > province > city > barangay).
 * Rows are linked by PSGC-style codes (region_id, province_id, city_id), not by primary keys.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('region_id', 10)->index();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('region_id', 10)->index();
            $table->string('province_id', 10)->index();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('region_id', 10);
            $table->string('province_id', 10)->index();
            $table->string('city_id', 10)->index();
        });

        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('region_id', 10);
            $table->string('province_id', 10);
            $table->string('city_id', 10)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangays');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('regions');
    }
};
