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
        Schema::create('praticien', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nom', 50)->nullable();
            $table->string('prenom', 60)->nullable();
            $table->string('adresse', 100)->nullable();
            $table->float('coef_notoriete')->nullable();
            $table->string('code_type_praticien', 6)->index('typ_code');
            $table->unsignedMediumInteger('id_ville')->index('id_ville');
            $table->decimal('Solde_congé', 11)->default(0);
            $table->decimal('Ancien_Solde_Congé', 10)->default(0);
            $table->integer('anciennete');
            $table->integer('id_echelon')->index('id_echelon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praticien');
    }
};
