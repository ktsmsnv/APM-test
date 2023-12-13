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
        Schema::create('workGroup', function (Blueprint $table) {
            $table->id();

            // Создаем внешний ключ для связи с таблицей projects
            $table->string('project_num');
            $table->foreign('project_num')->references('projNum')->on('projects');

            $table->string('projCurator')->nullable();
            $table->string('projDirector')->nullable();
            $table->string('techlid')->nullable();
            $table->string('production')->nullable();
            $table->string('supply')->nullable();
            $table->string('logistics')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workGroup');
    }
};
