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
        Schema::create('vawcs', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('cname');
            $table->string('nname');
            $table->date('dob');
            $table->string('pb');
            $table->unsignedSmallInteger('age');
            $table->string('gender', 10)->index();
            $table->string('religion');
            $table->string('p_address');
            $table->string('h_address');
            $table->string('educ_attain');
            $table->string('school');
            $table->date('date_int');
            $table->string('n_viewer');
            $table->text('problem');
            $table->text('findings');
            $table->text('remarks');

            // Family members, stored as parallel CSV lists
            $table->text('mem_fname')->nullable();
            $table->text('mem_relation')->nullable();
            $table->text('mem_age')->nullable();
            $table->text('mem_gender')->nullable();
            $table->text('mem_educ')->nullable();
            $table->text('mem_occup')->nullable();
            $table->text('mem_monthly')->nullable();
            $table->text('mem_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vawcs');
    }
};
