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
        Schema::create('notif_meds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dec');
            $table->foreign('id_dec')->references('id')->on('declarations')->onDelete('cascade');
            $table->unsignedBigInteger('id_med');
            $table->foreign('id_med')->references('id')->on('medecins')->onDelete('cascade');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notif_meds');
    }
};
