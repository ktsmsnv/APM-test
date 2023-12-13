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
        Schema::create('totals', function (Blueprint $table) {
                $table->id();
                // Создаем внешний ключ для связи с таблицей projects
                $table->string('project_num')->nullable(); 
                $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');
    
                $table->integer('kdDays')->nullable(); // Наименование строки
                $table->integer('equipmentDays')->nullable(); // Наименование строки
                $table->integer('productionDays')->nullable(); // Наименование строки
                $table->integer('shipmentDays')->nullable(); // Наименование строки
                $table->integer('periodDays')->nullable(); // Наименование строки
                $table->decimal('price', 10, 2)->nullable()->index(); //стоимость (руб. без НДС)
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totals');
    }
};
