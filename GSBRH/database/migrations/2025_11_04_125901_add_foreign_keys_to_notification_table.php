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
        Schema::table('notification', function (Blueprint $table) {
            $table->foreign(['id_ecrivian'], 'notification_ibfk_1')->references(['id'])->on('praticien')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_receveur'], 'notification_ibfk_2')->references(['id'])->on('praticien')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_etat'], 'notification_ibfk_3')->references(['id'])->on('etat_lecture')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropForeign('notification_ibfk_1');
            $table->dropForeign('notification_ibfk_2');
            $table->dropForeign('notification_ibfk_3');
        });
    }
};
