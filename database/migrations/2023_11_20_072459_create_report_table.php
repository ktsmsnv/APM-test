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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->string('project_num');
            // Создаем внешний ключ project_num
            $table->foreign('project_num')->references('projNum')->on('projects')->onUpdate('cascade');

            // Доходная часть
            $table->json('costRubW')->nullable(); //Стоимость по контракту Руб (без НДС)
            $table->json('costRub')->nullable(); //Стоимость по контракту Руб (c НДС)

            // Расходная часть плановое
            $table->string('expenseDirectPlan')->nullable(); //Прямые расходы, включая (расх.часть Плановое, руб (без НДС))
            $table->string('expenseMaterialPlan')->nullable(); //Затраты на материалы (голан) (расх.часть Плановое, руб (без НДС))
            $table->string('expenseDeliveryPlan')->nullable(); //Доставка (расх.часть Плановое, руб (без НДС))
            $table->string('expenseWorkPlan')->nullable(); // Затраты на работы (расх.часть Плановое, руб (без НДС))
            $table->string('expenseOtherPlan')->nullable(); // Прочие затраты (расх.часть Плановое, руб (без НДС))
            $table->string('expenseOpoxPlan')->nullable(); //ОПОХ (расх.часть Плановое, руб (без НДС))
            $table->string('marginProfitPlan')->nullable(); //Маржинальная прибыль (расх.часть Плановое, руб (без НДС))
            $table->string('marginalityPlan')->nullable(); //Маржинальность проекта, % (расх.часть Плановое, руб (без НДС))
            $table->string('profitPlan')->nullable(); //Прибыль до вычета налогов (расх.часть Плановое, руб (без НДС))
            $table->string('projProfitPlan')->nullable(); //Рентабельность проекта, % (расх.часть Плановое, руб (без НДС))
            // Расходная часть фактическое
            $table->string('expenseDirectFact')->nullable(); //Прямые расходы, включая (расх.часть Фактическое, руб (без НДС))
            $table->string('expenseMaterialFact')->nullable(); //Затраты на материалы (голан) (расх.часть Фактическое, руб (без НДС))
            $table->string('expenseDeliveryFact')->nullable(); //Доставка (расх.часть Фактическое, руб (без НДС))
            $table->string('expenseWorkFact')->nullable(); //Затраты на работы (расх.часть Фактическое, руб (без НДС))
            $table->string('expenseOtherFact')->nullable(); //Прочие затраты (расх.часть Фактическое, руб (без НДС))
            $table->string('expenseOpoxFact')->nullable(); //ОПОХ (расх.часть Фактическое, руб (без НДС))
            $table->string('marginProfitFact')->nullable(); //Маржинальная прибыль (расх.часть Фактическое, руб (без НДС))
            $table->string('marginalityFact')->nullable(); //Маржинальность проекта, % (расх.часть Фактическое, руб (без НДС))
            $table->string('profitFact')->nullable(); //Прибыль до вычета налогов (расх.часть Фактическое, руб (без НДС))
            $table->string('projProfitFact')->nullable(); //Рентабельность проекта, % (расх.часть Фактическое, руб (без НДС))

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report');
    }
};
