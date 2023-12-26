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
        Schema::create('smk_sub', function (Blueprint $table) {
            $table->id();
            $table->string('smk_main_id'); // Ссылка на smk_main
            $table->string('num');
            $table->decimal('cost', 10, 2);
            $table->decimal('period', 10, 2);
            $table->decimal('quality', 10, 2);

            $table->foreign('smk_main_id')->references('id')->on('smk_main')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smk_sub');
    }
};
