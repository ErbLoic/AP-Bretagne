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
        Schema::create('type_praticien', function (Blueprint $table) {
            $table->string('code', 6)->primary();
            $table->string('libelle', 50)->nullable();
            $table->string('lieu', 70)->nullable();
            $table->string('type', 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_praticien');
    }
};
