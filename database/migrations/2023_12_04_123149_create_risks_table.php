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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('risk_name')->nullable();
            $table->json('risk_reason')->nullable();
            $table->json('risk_consequences')->nullable();
            $table->integer('risk_probability')->nullable();
            $table->integer('risk_influence')->nullable();
            $table->integer('risk_estimate')->nullable();
            $table->string('risk_strategy')->nullable();
            $table->json('risk_counteraction')->nullable();
            $table->string('risk_term')->nullable();
            $table->string('risk_mark')->nullable();
            $table->json('risk_measures')->nullable();
            $table->string('risk_responsible')->nullable();
            $table->string('risk_endTerm')->nullable();
            $table->string('project_num')->index();
            $table->timestamps();

            $table->foreign('project_num')->references('projNum')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
