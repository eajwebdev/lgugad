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
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dafac_id')->constrained('dafacs')->cascadeOnDelete();
            $table->string('fam_mem');
            $table->string('em_dis');
            $table->string('assistance');
            $table->string('unit');
            $table->decimal('quantity', 10, 2);
            $table->decimal('cost', 12, 2);
            $table->string('provider');
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
        Schema::dropIfExists('assistances');
    }
};
