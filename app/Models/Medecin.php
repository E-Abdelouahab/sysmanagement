<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Medecin extends Model
{
    use HasFactory ;
    use Notifiable;
    protected $fillable = [
        'id_user', 'identifier', 'specialite', 'centre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


}
