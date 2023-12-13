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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id(); //порядковый номер строки

            // Создаем внешний ключ для связи с таблицей projects
            $table->string('project_num'); 
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            $table->string('nameTMC'); //наименование тмц 
            $table->string('manufacture'); //производитель
            $table->string('unit'); //ед.изм.
            $table->integer('count'); //кол-во
            $table->decimal('priceUnit', 10, 2); //цена за ед. (руб. без НДС)
            $table->decimal('price', 10, 2); //стоимость (руб. без НДС)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
