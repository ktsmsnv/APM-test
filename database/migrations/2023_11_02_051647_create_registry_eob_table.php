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
        Schema::create('registry_eob', function (Blueprint $table) {
            $table->id(); // Номер записи (id), автоинкрементируемое поле
            $table->string('vnNum'); // Вн. Номер
            $table->string('purchaseName'); // Наименование закупки
            $table->boolean('delivery')->nullable(); // Поставка
            $table->boolean('pir')->nullable(); // ПИР
            $table->boolean('kd')->nullable(); // КД
            $table->boolean('prod')->nullable(); // Про-во
            $table->boolean('shmr')->nullable(); // ШМР
            $table->boolean('pnr')->nullable(); // ПНР
            $table->boolean('po')->nullable(); // ПО
            $table->boolean('smr')->nullable(); // СМР
            $table->string('purchaseOrg'); // Наименование организатора закупки
            $table->string('endUser'); // Головная компания
            $table->string('object'); // Объект
            $table->string('area'); // Площадка
            $table->date('receiptDate'); // Дата поступления заявки
            $table->date('submissionDate'); // Дата подачи предложения
            $table->string('projectManager'); // Руководитель проекта
            $table->string('tech'); // Тех.специалист
            $table->text('primeCost'); // Себестоимость
            $table->string('tkpCost'); // Цена ТКП руб. с НДС
            $table->text('notes')->nullable(); // Примечания
            $table->timestamps(); // Поля для хранения даты и времени создания и обновления записи
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registry_eob');
    }
};
