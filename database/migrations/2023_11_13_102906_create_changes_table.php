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
        Schema::create('changes', function (Blueprint $table) {
                $table->id();
                $table->string('project_num')->nullable();
                $table->string('project');
                $table->string('contractor');
                $table->string('contract_num');
                $table->string('change');
                $table->string('impact');
                $table->string('stage');
                $table->string('corrective');
                $table->string('responsible');

                // Создаем внешний ключ project_num
                $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

                // Остальные внешние ключи:
                $table->foreign('project')->references('projNum')->on('projects')->onUpdate('cascade');
                $table->foreign('contractor')->references('contractor')->on('projects')->onUpdate('cascade');
                $table->foreign('contract_num')->references('contract_num')->on('basic_info')->onUpdate('cascade');
                $table->foreign('responsible')->references('projManager')->on('projects')->onUpdate('cascade');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('changes');
    }
};
