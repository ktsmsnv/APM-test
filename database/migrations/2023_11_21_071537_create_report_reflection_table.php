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
        Schema::create('report_reflection', function (Blueprint $table) {
            $table->id();

            $table->string('project_num');
            // Создаем внешний ключ project_num
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            $table->string('devRKD_adv')->nullable(); //Разработка РКД (Положительные аспекты)
            $table->string('complection_adv')->nullable(); //Комплектация(Положительные аспекты)
            $table->string('production_adv')->nullable(); //Производство (Положительные аспекты)
            $table->string('shipment_adv')->nullable(); //Отгрузка (Положительные аспекты)

            $table->string('devRKD_dis')->nullable(); //Разработка РКД (Отрицательные аспекты)
            $table->string('complection_dis')->nullable(); //Комплектация(Отрицательные аспекты)
            $table->string('production_dis')->nullable(); //Производство (Отрицательные аспекты)
            $table->string('shipment_dis')->nullable(); //Отгрузка (Отрицательные аспекты)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_reflection');
    }
};
