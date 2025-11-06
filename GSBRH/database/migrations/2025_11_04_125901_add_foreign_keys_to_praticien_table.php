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
        Schema::table('praticien', function (Blueprint $table) {
            $table->foreign(['code_type_praticien'], 'praticien_ibfk_1')->references(['code'])->on('type_praticien')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_ville'], 'praticien_ibfk_2')->references(['id'])->on('ville')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_echelon'], 'praticien_ibfk_3')->references(['id_echelon'])->on('Echelon')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('praticien', function (Blueprint $table) {
            $table->dropForeign('praticien_ibfk_1');
            $table->dropForeign('praticien_ibfk_2');
            $table->dropForeign('praticien_ibfk_3');
        });
    }
};
