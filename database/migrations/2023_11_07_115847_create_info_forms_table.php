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
        Schema::create('info_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dec');
            $table->foreign('id_dec')->references('id')->on('declarations');
            $table->unsignedBigInteger('id_cit');
            $table->foreign('id_cit')->references('id')->on('citoyens');
            $table->date('dateReclam')->nullable();
            $table->string('fulNamevic')->nullable();
            // $table->string('prenom')->nullable();
            $table->date('dateN')->nullable();
            $table->string('lieuN')->nullable();
            $table->string('cin')->nullable();
            $table->string('adress')->nullable();
            $table->integer('age')->nullable();
            $table->string('nationnalite')->nullable();
            $table->boolean('dejaSignale')->nullable();
            $table->string('lieuSignal')->nullable();
            $table->date('dateSingnal')->nullable();
            $table->string('ville')->nullable();
            $table->integer('NbrAgre')->nullable();
            $table->string('RaisonVisit')->nullable();
            $table->string('milieuResid')->nullable();
            $table->string('handicap')->nullable();
            $table->string('addiction')->nullable();
            $table->string('niveauScolaire')->nullable();
            $table->string('professionE')->nullable();
            $table->string('stituationParent')->nullable();
            $table->string('professionMere')->nullable();
            $table->string('prefessionPere')->nullable();
            $table->string('parrain')->nullable();
            $table->string('niveauScolaireParrain')->nullable();
            $table->string('addictionParrain')->nullable();
            $table->string('teleParrain')->nullable();
            $table->string('dureeMariage')->nullable();
            $table->string('situationFamiliale')->nullable();
            $table->integer('nbrEnf')->nullable();
            $table->boolean('enceint')->nullable();
            $table->string('professionF')->nullable();
            $table->string('vPhysique')->nullable();
            $table->string('vPsychique')->nullable();
            $table->string('cPhysique')->nullable();
            $table->string('cSexuelle')->nullable();
            $table->string('egligence')->nullable();
            $table->string('abondonnement')->nullable();
            $table->string('traiteHumain')->nullable();
            $table->string('frequenceV')->nullable();
            $table->string('typeRelation')->nullable();
            $table->string('serviceProd')->nullable();
            $table->string('delivCertif')->nullable();
            $table->string('soins')->nullable();
            $table->string('orientationEtab')->nullable();
            $table->string('orientationHospitalier')->nullable();
            $table->string('certificat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_forms');
    }
};
