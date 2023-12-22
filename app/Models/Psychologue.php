<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Psychologue extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        'id_user', 'identifier', 'centre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
