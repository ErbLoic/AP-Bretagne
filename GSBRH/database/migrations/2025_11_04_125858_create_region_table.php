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
        Schema::create('region', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('code', 3)->nullable()->index('code');
            $table->string('nom')->nullable();
            $table->string('nom_reel')->nullable();
            $table->string('commune', 4)->nullable();
            $table->string('monnaie', 20)->nullable();
            $table->string('fuseau', 20)->nullable();
            $table->string('indicatif', 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('region');
    }
};
