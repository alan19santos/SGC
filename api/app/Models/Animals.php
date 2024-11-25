<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Animals extends Model
{
    use HasFactory;
    
    protected $fillable = ['size', 'breed'];
    
    public function resident() {
        return $this->belongsToMany(Resident::class, 'resident_animals', 'animal_id', 'resident_id');
    }
}
