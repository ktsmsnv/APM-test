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
        Schema::create('basic_reference', function (Blueprint $table) {
            $table->id(); //порядковый номер строки
            // Создаем нужные поля
            $table->string('project_num'); 
            $table->string('projName'); // 1.1. наименование проекта (projName)
            $table->string('projCustomer'); // 1.2. заказчик проекта (projCustomer)
            $table->date('startDate')->index(); // 1.3. начало проекта (startDate)
            $table->date('endDate')->index(); // 1.4. окончание проекта (endDate)
            $table->string('projGoal'); // 1.5. цель проекта (projGoal)
            $table->string('projCurator'); // 1.5. цель проекта (projGoal)
            $table->string('projManager'); // 1.6. руководитель/инициатор проекта (projDirector)


            // Создаем внешний ключ project_num
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            // Остальные внешние ключи:
            $table->foreign('projCustomer')->references('endCustomer')->on('projects')->onUpdate('cascade');
            $table->foreign('projManager')->references('projManager')->on('projects')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_reference');
    }
};
