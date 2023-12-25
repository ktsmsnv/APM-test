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
        Schema::create('base_possibilities', function (Blueprint $table) {
            $table->id(); // Номер записи (id), автоинкрементируемое поле
            $table->string('nameRisk')->nullable(); // Наименование возможности
            $table->json('reasonRisk')->nullable(); // Причина возможности
            $table->json('conseqRiskOnset')->nullable(); // Последствия наступления возможности
            $table->json('counteringRisk')->nullable(); // мероприятия в отношении возникновения возможности
            $table->string('term')->nullable(); // Срок
            $table->json('riskManagMeasures')->nullable(); // Мероприятия при осуществлении возможности
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_possibilities');
    }
};
