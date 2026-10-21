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
        Schema::create('pwds', function (Blueprint $table) {
            $table->id();
            $table->string('applicant');
            $table->string('person_with');
            $table->date('date_app');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('suffix')->nullable();
            $table->date('dob');
            $table->string('gender', 10)->index();
            $table->string('c_status');
            $table->text('type_dis')->nullable();
            $table->text('cause_dis')->nullable();
            $table->string('r_address');
            $table->string('street')->nullable();
            $table->unsignedBigInteger('brangay')->nullable()->index(); // mabinay_brgys.id
            $table->string('municipality');
            $table->string('province');
            $table->string('region');
            $table->string('l_no')->nullable();
            $table->string('m_no')->nullable();
            $table->string('email')->nullable();
            $table->string('educ_attain');
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
        Schema::dropIfExists('pwds');
    }
};
