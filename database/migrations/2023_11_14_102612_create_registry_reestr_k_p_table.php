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
        Schema::create('registry_reestrKP', function (Blueprint $table) {
            $table->id(); // Номер записи (id), автоинкрементируемое поле
            $table->string('numIncoming'); // № исходящего
            $table->date('date'); // Дата
            $table->string('orgName'); // Наименование организации
            $table->string('whom'); // Кому
            $table->string('sender'); // Отправитель
            $table->string('amountNDS'); // Сумма, с НДС
            $table->string('purchNum'); // № закупки
            $table->string('note'); // Примечания
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registry_reestrKP');
    }
};
