<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calc_risks', function (Blueprint $table) {
            $table->id();

             $table->string('project_num');
            $table->foreign('project_num')->references('projNum')->on('projects');
            $table->string('calcRisk_name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calc_risks');
    }
};
