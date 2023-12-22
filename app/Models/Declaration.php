<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Declaration extends Model
{
    use HasFactory,Notifiable;


    protected $fillable = [
        'id_cit', 'heur_v', 'date_v', 'lieu_v', 'comment'
    ];

    public function citoyen()
    {
        return $this->belongsTo(Citoyen::class, 'id_cit');
    }

    public function infoForm()
    {
        return $this->hasOne(InfoForm::class, 'id_dec');
    }

    public function agresseurs()
    {
        return $this->hasMany(infoAgresseur::class, 'id_dec');
    }

    public function roadmaps()
    {
        return $this->hasMany(roadmap::class, 'id_dec');
    }
}
