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
        Schema::create('ville', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('nom_ville', 45)->nullable()->index('ville_nom');
            $table->string('nom_reel', 45)->nullable()->index('ville_nom_reel');
            $table->string('code_postal')->nullable()->index('ville_code_postal');
            $table->string('commune', 3)->nullable();
            $table->string('code_commune', 5)->index('ville_code_commune');
            $table->unsignedSmallInteger('arrondissement')->nullable();
            $table->integer('id_departement')->index('departement_id');

            $table->unique(['code_commune'], 'ville_code_commune_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ville');
    }
};
