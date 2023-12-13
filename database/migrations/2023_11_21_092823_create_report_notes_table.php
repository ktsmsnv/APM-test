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
        Schema::create('report_notes', function (Blueprint $table) {
            $table->id();

            $table->string('project_num');
            // Создаем внешний ключ project_num
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            $table->string('projNotes')->nullable(); //Примечания к проекту
            $table->string('teamNotes')->nullable(); //Примечания к команде проекта
            $table->string('resume')->nullable(); //Общее резюме по проекту (что улучшить, точки роста)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_notes');
    }
};
