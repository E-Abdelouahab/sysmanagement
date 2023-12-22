<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_dec', 'id_cit', 'dateReclam', 'fulNamevic', 'dateN', 'lieuN',
        'cin', 'adress', 'age', 'nationnalite', 'dejaSignale', 'lieuSignal',
        'dateSingnal', 'ville', 'NbrAgre', 'RaisonVisit', 'milieuResid',
        'handicap', 'addiction', 'niveauScolaire', 'professionE', 'stituationParent',
        'professionMere', 'prefessionPere', 'parrain', 'niveauScolaireParrain',
        'addictionParrain', 'teleParrain', 'dureeMariage', 'situationFamiliale',
        'nbrEnf', 'enceint', 'professionF', 'vPhysique', 'vPsychique', 'cPhysique',
        'cSexuelle', 'egligence', 'abondonnement', 'traiteHumain', 'frequenceV',
        'typeRelation',  'serviceProd',
        'delivCertif', 'soins', 'orientationEtab', 'orientationHospitalier',
        'certificat'
    ];

    public function declaration()
    {
        return $this->belongsTo(Declaration::class, 'id_dec');
    }

    public function citoyen()
    {
        return $this->belongsTo(Citoyen::class, 'id_cit');
    }


}
