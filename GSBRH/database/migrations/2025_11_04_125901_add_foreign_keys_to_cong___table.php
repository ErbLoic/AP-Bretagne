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
        Schema::table('congé', function (Blueprint $table) {
            $table->foreign(['état'], 'congé_ibfk_1')->references(['Id_etat'])->on('etat')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['Id_praticien'], 'congé_ibfk_2')->references(['id'])->on('praticien')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('congé', function (Blueprint $table) {
            $table->dropForeign('congé_ibfk_1');
            $table->dropForeign('congé_ibfk_2');
        });
    }
};
