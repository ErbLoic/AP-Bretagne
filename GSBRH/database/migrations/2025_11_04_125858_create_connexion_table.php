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
        Schema::create('connexion', function (Blueprint $table) {
            $table->string('identifiant', 50)->primary();
            $table->string('mdp');
            $table->integer('id_praticiens')->index('id_praticiens');
            $table->integer('privilèges')->index('privilèges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connexion');
    }
};
