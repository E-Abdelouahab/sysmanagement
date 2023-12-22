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
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->string('heur_v')->nullable();
            $table->date('date_v')->nullable();
            $table->string('lieu_v')->nullable();
            $table->unsignedBigInteger('id_cit');
            $table->string('comment')->nullable();
            $table->foreign('id_cit')->references('id')->on('citoyens');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declarations');
    }
};
