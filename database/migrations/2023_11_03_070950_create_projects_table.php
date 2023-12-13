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
        Schema::create('projects', function (Blueprint $table) {
            // Таблица "Общая информация" (Projects):
            $table->id(); 
            $table->string('projNum')->unique();  //номер проекта по реестру 
            $table->string('projManager')->index(); //руководитель проекта
            $table->string('objectName'); //наименование объекта
            $table->string('endCustomer')->index(); // конечный заказчик
            $table->string('contractor')->index(); // контрагент
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
