<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifMed extends Model
{
    use HasFactory;
    protected $table = 'notif_meds';

    protected $fillable = [
        'id_dec',
        'id_med',
        'message',
    ];

    public function declaration()
    {
        return $this->belongsTo(Declaration::class, 'id_dec');
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'id_med');
    }
}
