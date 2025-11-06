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
        Schema::create('departement', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 3)->nullable()->index('departement_code');
            $table->string('nom_departement')->nullable();
            $table->string('nom_reel')->nullable();
            $table->unsignedTinyInteger('id_region')->index('id_region');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departement');
    }
};
