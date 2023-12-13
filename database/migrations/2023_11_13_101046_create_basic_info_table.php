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
        Schema::create('basic_info', function (Blueprint $table) {
            $table->id(); //порядковый номер строки
            // Создаем нужные поля
            $table->string('project_num')->nullable();
            $table->string('contractor')->nullable(); //контрагент  
            $table->string('contract_num')->nullable()->index(); // № договора/спецификации
            $table->decimal('price_plan')->nullable(); //себестоимость план
            $table->decimal('price_fact')->nullable(); //себестоимость факт
            $table->decimal('contract_price')->nullable(); // стоимость контракта
            $table->decimal('profit_plan')->nullable(); //прибыль план 
            $table->decimal('profit_fact')->nullable(); //прибыль факт
            $table->date('start_date')->nullable(); //дата начала
            $table->date('end_date_plan')->nullable(); //дата окончания план
            $table->date('end_date_fact')->nullable(); //дата окончания факт
            $table->string('complaint')->nullable(); //рекламация

            // Создаем внешний ключ project_num
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            // Остальные внешние ключи:
            $table->foreign('contractor')->references('Contractor')->on('projects')->onUpdate('cascade');
            $table->foreign('price_plan')->references('Price')->on('totals')->onUpdate('cascade');
            $table->foreign('start_date')->references('startDate')->on('basic_reference')->onUpdate('cascade');
            $table->foreign('end_date_plan')->references('endDate')->on('basic_reference')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_info');
    }
};
