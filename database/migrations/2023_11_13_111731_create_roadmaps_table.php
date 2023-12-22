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
        Schema::create('roadmaps', function (Blueprint $table) {
            $table->id();
            $table->string('etat');
            $table->unsignedBigInteger('id_step')->nullable();
            $table->unsignedBigInteger('id_dec');
            $table->unsignedBigInteger('id_cit');
            $table->foreign('id_step')->references('id')->on('steps');
            $table->foreign('id_dec')->references('id')->on('declarations')->onDelete('cascade');
            $table->foreign('id_cit')->references('id')->on('citoyens')->onDelete('cascade');
            $table->datetime('date_debut')->nullable();
            $table->datetime('date_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmaps');
    }
};
