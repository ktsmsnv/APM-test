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
        Schema::create('markups', function (Blueprint $table) {
            $table->id();

            // Создаем внешний ключ для связи с таблицей projects
            $table->string('project_num'); 
            $table->foreign('project_num')->references('projNum')->on('projects');

            $table->date('date'); //дата
            $table->decimal('percentage', 5, 2); // % наценки
            $table->decimal('priceSubTkp', 10, 2)->nullable(); // Сумма подачи ТКП в руб. без НДС
            $table->string('agreedFio'); // С кем согласовано (фамилия и.о.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markup');
    }
};
