<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Steps extends Model
{
    use HasFactory;
    protected $table = 'steps';
    protected $fillable = ['name'];

    public function roadmaps()
    {
        return $this->belongsToMany(roadmap::class, 'roadmap_step', 'step_id', 'roadmap_id');
    }

    // public function cars()
    // {
    //     return $this->belongsTo(Roadmap::class, 'id_step');
    // }
}
