<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class roadmap extends Model
{
    use HasFactory;
    protected $table = 'roadmaps';
    protected $fillable = ['etat', 'id_step', 'id_dec', 'id_cit','date_debut','date_fin'];

    public function steps()
    {
        return $this->belongsToMany(Steps::class, 'roadmap_step', 'roadmap_id', 'step_id');
    }


    public function declaration()
    {
        return $this->belongsTo(Declaration::class, 'id_dec');
    }


    public function citoyen()
    {
        return $this->belongsTo(Citoyen::class, 'id_cit');
    }
}
