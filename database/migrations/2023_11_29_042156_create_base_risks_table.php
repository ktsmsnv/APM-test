<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('base_risks', function (Blueprint $table) {
            $table->id(); // Номер записи (id), автоинкрементируемое поле
            $table->string('nameRisk')->nullable(); // Наименование риска
            $table->json('reasonRisk')->nullable(); // Причина риска
            $table->json('conseqRiskOnset')->nullable(); // Последствия наступления риска
            $table->json('counteringRisk')->nullable(); // Противодействие риску
            $table->string('term')->nullable(); // Срок
            $table->json('riskManagMeasures')->nullable(); // Мероприятия при осуществлении риска
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('base_risks');
    }
};
