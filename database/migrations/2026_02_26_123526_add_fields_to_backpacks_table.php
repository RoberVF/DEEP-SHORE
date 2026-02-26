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
        Schema::table('backpacks', function (Blueprint $table) {
            $table->string('brand')->nullable();
            $table->decimal('capacity_liters', 5, 1)->nullable();
            $table->integer('max_weight_grams')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backpacks', function (Blueprint $table) {
            $table->dropColumn('brand');
            $table->dropColumn('capacity_liters');
            $table->dropColumn('max_weight_grams');
        });
    }
};
