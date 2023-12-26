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
        Schema::create('smk_main', function (Blueprint $table) {
            $table->id();
            $table->string('project_num');
            $table->text('project_cost_desc');
            $table->text('project_period_desc');
            $table->text('project_quality_desc');
            $table->decimal('project_cost_fi', 10, 2);
            $table->decimal('project_period_fi', 10, 2);
            $table->decimal('project_quality_fi', 10, 2);
            $table->decimal('project_cost_ki', 10, 2);
            $table->decimal('project_period_ki', 10, 2);
            $table->decimal('project_quality_ki', 10, 2);

            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smk_main');
    }
};
