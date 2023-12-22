<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ong extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user', 'identifier',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
