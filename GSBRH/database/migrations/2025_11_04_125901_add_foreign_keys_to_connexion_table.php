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
        Schema::table('connexion', function (Blueprint $table) {
            $table->foreign(['id_praticiens'], 'connexion_ibfk_1')->references(['id'])->on('praticien')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['privilèges'], 'connexion_ibfk_2')->references(['id'])->on('utilisateur')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('connexion', function (Blueprint $table) {
            $table->dropForeign('connexion_ibfk_1');
            $table->dropForeign('connexion_ibfk_2');
        });
    }
};
