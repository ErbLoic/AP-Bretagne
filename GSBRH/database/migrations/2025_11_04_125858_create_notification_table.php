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
        Schema::create('notification', function (Blueprint $table) {
            $table->integer('id_notif', true);
            $table->integer('id_ecrivian')->index('id_ecrivian');
            $table->integer('id_receveur')->index('id_receveur');
            $table->string('message', 250);
            $table->integer('id_etat')->index('id_etat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
