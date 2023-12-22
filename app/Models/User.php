<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullName', 
        'cin',
        'email',
        'phone',
        'password',
        'dateN', 
        'sexe', 
        'role'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    
    public function assistantSocial()
    {
        return $this->hasOne(AssistantSocial::class, 'id_user');
    }

    public function citoyens()
    {
        return $this->hasOne(Citoyen::class, 'id_user');
    }

    public function supperAdmin()
    {
        return $this->hasOne(SupperAdmin::class, 'id_user');
    }

    public function medecin()
    {
        return $this->hasOne(Medecin::class, 'id_user');
    }

    public function psychologue()
    {
        return $this->hasOne(Psychologue::class, 'id_user');
    }

    public function assistantChp()
    {
        return $this->hasOne(AssistantChp::class, 'id_user');
    }

    public function assistantC()
    {
        return $this->hasOne(AssistantC::class, 'id_user');
    }

    public function ong()
    {
        return $this->hasOne(Ong::class, 'id_user');
    }
    
    public function calendrier()
    {
        return $this->hasMany(calendrier::class, 'id_user');
    }

}
