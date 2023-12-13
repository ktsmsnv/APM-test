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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // Создаем внешний ключ для связи с таблицей projects
            $table->string('project_num'); 
            $table->foreign('project_num')->references('projNum')->on('projects');

            $table->string('fio'); // фио
            $table->string('post'); // Должность
            $table->string('responsibility'); // Зона ответственности
            $table->string('contact'); // тел или почта
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
