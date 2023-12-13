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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            // Создаем внешний ключ для связи с таблицей projects
            $table->string('project_num'); 
            $table->foreign('project_num')->references('projNum')->on('projects');

            $table->string('commandir'); // командировочные
            $table->string('rd'); // командировочные
            $table->string('shmr'); // командировочные
            $table->string('pnr'); // командировочные
            $table->string('cert'); // командировочные
            $table->string('delivery'); // командировочные
            $table->string('rastam'); // командировочные
            $table->string('ppo'); // командировочные
            $table->string('guarantee'); // командировочные
            $table->string('check'); // командировочные
            $table->string('total'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
