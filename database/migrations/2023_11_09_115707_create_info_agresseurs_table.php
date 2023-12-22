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
        Schema::create('info_agresseurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dec');
            $table->foreign('id_dec')->references('id')->on('declarations');
            $table->string('fullNameAg')->nullable();
            $table->string('sexeAg')->nullable();
            $table->string('nationnaliteAg')->nullable();
            $table->integer('ageAg')->nullable();
            $table->string('professionAg')->nullable();
            $table->string('niveauScolaireAg')->nullable();
            $table->string('situationFamilialeAg')->nullable();
            $table->string('carractAg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_agresseurs');
    }
};
