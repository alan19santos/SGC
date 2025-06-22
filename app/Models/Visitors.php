<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    protected $fillable = ['name',
    'tower',
    'date',
    'rg',
    'entry_time',
    'concierge_visa',
    'observation',
    'condominium_id'];

    public function condominium(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Condominium::class, 'id', 'condominium_id');
    }
}


