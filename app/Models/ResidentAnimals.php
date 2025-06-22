<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentAnimals extends Model
{
    use HasFactory;

    protected $table = 'resident_animals';

    protected $fillable = ['resident_id', 'animal_id'];
}
