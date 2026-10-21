<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Senior citizen record: `citizens` plus four one-to-one detail tables keyed by `cid`.
 *
 * Checkbox groups are stored as fixed-length CSV strings where each slot is one option
 * (e.g. ',,,' = 4 empty slots). The defaults below define the slot count the UI expects,
 * so they must not be removed.
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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('lname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('ext')->nullable();
            $table->string('status')->default('Waiting');
            $table->string('profile')->nullable();
            $table->text('files')->nullable();
            $table->timestamps();

            $table->index(['lname', 'fname', 'mname']);
        });

        Schema::create('citizen_i_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cid')->unique()->constrained('citizens')->cascadeOnDelete();
            $table->date('bday')->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->string('p_birth')->nullable();
            $table->string('m_status')->nullable();
            $table->string('gender', 10)->nullable()->index();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('religion')->nullable();
            $table->string('ethic_org')->nullable();
            $table->string('ph')->nullable();
            $table->string('sc_ass')->nullable();
            $table->string('other_gov')->nullable();
            $table->string('camp_travel')->nullable();
            $table->string('add_region', 10)->nullable();
            $table->string('add_prov', 10)->nullable();
            $table->string('add_city', 10)->nullable();
            $table->unsignedBigInteger('add_brgy')->nullable(); // barangays.id
            $table->string('brgy')->nullable();
            $table->string('house_purok')->nullable();
            $table->string('street')->nullable();
            $table->string('lang_spoke')->nullable();
            $table->string('osca_idnum', 10)->nullable()->unique();
            $table->string('gsis_sss')->nullable();
            $table->string('tin')->nullable();
            $table->string('sbe')->nullable();
            $table->string('curr_pension')->nullable();
            $table->timestamps();
        });

        Schema::create('citizen_i_i_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cid')->unique()->constrained('citizens')->cascadeOnDelete();
            foreach (['spouse', 'father', 'mother'] as $person) {
                $table->string("{$person}_lname")->nullable();
                $table->string("{$person}_fname")->nullable();
                $table->string("{$person}_mname")->nullable();
                $table->string("{$person}_ext")->nullable();
            }
            foreach (['child', 'depend'] as $group) {
                foreach (['fname', 'occup', 'income', 'age', 'working'] as $field) {
                    $table->string("{$group}_{$field}")->default(',,,');
                }
            }
            $table->timestamps();
        });

        Schema::create('citizen_i_i_i_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cid')->unique()->constrained('citizens')->cascadeOnDelete();
            $table->string('educ_attain')->default(',,,,,,,,');
            $table->string('share_skill')->default(',,');
            $table->string('area_techskill')->default(',,,,,,,,,,,,,,,,,,,');
            $table->string('comm_serveinv')->default(',,,,,,,,,,,');
            $table->timestamps();
        });

        Schema::create('citizen_bcks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cid')->unique()->constrained('citizens')->cascadeOnDelete();
            $table->string('living_reside')->default(',,,,,,,,,');
            $table->string('house_cond')->default(',,,,,,');
            $table->string('source_inass')->default(',,,,,,,,,,,');
            $table->string('assreal_immov')->default(',,,,,');
            $table->string('assr_permov')->default(',,,,,,,,');
            $table->string('month_inc')->default(',,,,,,,,');
            $table->string('prob_needs')->default(',,,,,,,,');
            $table->string('med_concern')->default(',,,,,,,,,,');
            $table->string('den_conern')->default(',');
            $table->string('optical')->default(',,');
            $table->string('hearing')->default(',');
            $table->string('soc_emo')->default(',,,,,');
            $table->string('area_diff')->default(',,,');
            $table->string('med_main')->default(',,,,,,,,,,,');
            $table->string('med_sched')->nullable();
            $table->string('med_schedyes')->nullable();
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
        Schema::dropIfExists('citizen_bcks');
        Schema::dropIfExists('citizen_i_i_i_s');
        Schema::dropIfExists('citizen_i_i_s');
        Schema::dropIfExists('citizen_i_s');
        Schema::dropIfExists('citizens');
    }
};
