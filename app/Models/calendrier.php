<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class calendrier extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_debut', 
        'date_fin',
        'victimeName',
        'id_user',
        'role'
    ];


    public function calendrier()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
