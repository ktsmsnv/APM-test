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
        Schema::create('additional_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kp_id');
            $table->foreign('kp_id')->references('id')->on('registry_reestrKP')->onDelete('cascade');
            $table->string('file_name'); // Имя файла
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_files');
    }
};
