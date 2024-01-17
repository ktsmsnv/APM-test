<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Add new boolean fields
            $table->boolean('delivery')->default(false);
            $table->boolean('pir')->default(false);
            $table->boolean('kd')->default(false);
            $table->boolean('production')->default(false);
            $table->boolean('smr')->default(false);
            $table->boolean('pnr')->default(false);
            $table->boolean('po')->default(false);
            $table->boolean('cmr')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Reverse the changes (drop the added fields)
            $table->dropColumn(['delivery', 'pir', 'kd', 'production', 'smr', 'pnr', 'po', 'cmr']);
        });
    }
};
