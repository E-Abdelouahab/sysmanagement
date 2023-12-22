<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citoyen extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'uuid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function declarations()
    {
        return $this->hasMany(Declaration::class, 'id_cit');
    }

    public function infoForms()
    {
        return $this->hasMany(InfoForm::class, 'id_cit');
    }
    public function roadmap()
    {
        return $this->hasOne(roadmap::class, 'id_cit');
    }
}
