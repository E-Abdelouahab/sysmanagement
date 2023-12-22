<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class infoAgresseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_dec',
        'fullNameAg',
        'sexeAg', 
        'nationnaliteAg', 
        'ageAg', 
        'professionAg',
        'niveauScolaireAg', 
        'situationFamilialeAg', 
        'carractAg',
    ];

    public function agresseurs()
    {
        return $this->belongsTo(Declaration::class, 'id_dec');
    }
}
