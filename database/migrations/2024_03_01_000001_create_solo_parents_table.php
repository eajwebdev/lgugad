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
        Schema::create('solo_parents', function (Blueprint $table) {
            $table->id();
            $table->string('cname');
            $table->string('gender', 10)->index();
            $table->date('dob');
            $table->unsignedSmallInteger('age');
            $table->string('address');
            $table->string('h_education');
            $table->string('occupation');
            $table->string('monthly_income');
            $table->text('class_circum');
            $table->text('needs_prob');

            // Family members, stored as parallel CSV lists
            $table->text('mem_fname')->nullable();
            $table->text('mem_relation')->nullable();
            $table->text('mem_age')->nullable();
            $table->text('mem_status')->nullable();
            $table->text('mem_educ')->nullable();
            $table->text('mem_bdate')->nullable();

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
        Schema::dropIfExists('solo_parents');
    }
};
