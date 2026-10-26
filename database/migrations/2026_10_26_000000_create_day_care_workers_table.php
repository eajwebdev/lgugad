<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Child Development (Day Care) Worker profiles, laid out like ECCD Council Form 6.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_care_workers', function (Blueprint $table) {
            $table->id();

            // I. Personal information
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('sex', 10)->index();
            $table->date('birthday');
            $table->string('religion')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('civil_status', 20);
            $table->unsignedSmallInteger('no_children')->nullable();
            $table->string('address_no')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_barangay');
            $table->string('address_city')->nullable();
            $table->string('address_province')->nullable();
            $table->string('address_region')->nullable();
            $table->string('home_no')->nullable();
            $table->string('office_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('fax_no')->nullable();
            $table->string('email')->nullable();
            $table->string('education')->nullable();
            $table->string('degree')->nullable();
            $table->json('eligibility')->nullable();
            $table->string('eligibility_other')->nullable();

            // II. Work-related information
            $table->unsignedTinyInteger('years_as_cdw')->nullable();
            $table->string('center_name');
            $table->json('compensation_types')->nullable();
            $table->decimal('total_compensation', 12, 2)->nullable();
            $table->json('compensation_sources')->nullable();
            $table->decimal('amount_barangay', 12, 2)->nullable();
            $table->decimal('amount_city', 12, 2)->nullable();
            $table->decimal('amount_ngo', 12, 2)->nullable();
            $table->decimal('amount_parents', 12, 2)->nullable();
            $table->string('source_others')->nullable();
            $table->string('employment_term')->nullable();
            // Fixed-size lists (4 trainings, 2 courses) as on the paper form; JSON because titles may contain commas.
            $table->json('trainings')->nullable();
            $table->json('other_courses')->nullable();
            $table->string('accreditation_status', 30)->nullable();
            $table->date('date_accredited')->nullable();
            $table->string('accreditation_no')->nullable();
            $table->unsignedTinyInteger('accreditation_level')->nullable();

            // III. Working conditions
            $table->unsignedSmallInteger('children_served')->nullable();
            $table->unsignedTinyInteger('sessions_per_day')->nullable();
            $table->string('hours_per_session', 5)->nullable();
            $table->json('children_ages')->nullable();
            $table->string('hours_in_center', 10)->nullable();
            $table->string('session_method')->nullable();
            $table->date('date_conducted')->nullable();

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
        Schema::dropIfExists('day_care_workers');
    }
};
