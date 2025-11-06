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
        Schema::create('Echelon', function (Blueprint $table) {
            $table->integer('id_echelon')->primary();
            $table->string('duree', 100);
            $table->decimal('salaire_brut', 11);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Echelon');
    }
};
