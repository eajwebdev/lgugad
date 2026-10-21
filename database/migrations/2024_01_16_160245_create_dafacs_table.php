<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dafacs', function (Blueprint $table) {
            $table->id();

            // Location
            $table->string('add_region', 10)->nullable();
            $table->string('add_prov', 10)->nullable();
            $table->string('add_city', 10)->nullable();
            $table->unsignedBigInteger('add_brgy')->nullable()->index(); // barangays.id
            $table->string('district')->nullable();
            $table->string('brgy_evac_site')->nullable();
            $table->string('count', 10)->nullable();
            $table->string('serial')->nullable();

            // Family head
            $table->string('surname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('ext')->nullable();
            $table->string('gender', 10);
            $table->date('d_birth')->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->string('b_place')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('m_maid_name')->nullable();
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('mincome', 12, 2)->nullable();
            $table->unsignedBigInteger('city_mun_head')->nullable(); // barangays.id
            $table->string('id_present')->nullable();
            $table->string('id_cardnum')->nullable();
            $table->string('contact_1')->nullable();
            $table->string('contact_2')->nullable();
            $table->string('per_address')->nullable();
            $table->boolean('ps_benef')->default(false);
            $table->boolean('ip')->default(false);
            $table->string('type_ethnicity')->nullable();
            $table->string('checklist')->default('0,0,0,0,0,0');

            // Family members, stored as parallel CSV lists
            $table->text('mem_fname')->nullable();
            $table->text('mem_relation')->nullable();
            $table->text('mem_bdate')->nullable();
            $table->text('mem_age')->nullable();
            $table->text('mem_gender')->nullable();
            $table->text('mem_educ')->nullable();
            $table->text('mem_occup')->nullable();
            $table->text('mem_remarks')->nullable();

            $table->timestamps();

            $table->index('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dafacs');
    }
};
