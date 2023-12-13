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
        Schema::create('report_team', function (Blueprint $table) {
            $table->id();

            $table->string('project_num');
            // Создаем внешний ключ project_num
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            $table->string('roleFio')->nullable(); //ФИО (роль в проекте)
            $table->string('roleDescription')->nullable(); //Расширенное описание роли
            $table->string('roleImpact')->nullable(); //Вклад в успех проекта, %
            $table->string('roleBonus')->nullable(); //Дополнительная премия, руб. без НДС

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_team');
    }
};
