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
        Schema::table('projects', function (Blueprint $table) {
            $table->date('date_application')->nullable(); // Дата поступления заявки
            $table->date('date_offer')->nullable(); // Дата подачи предложения
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      
    }
};
