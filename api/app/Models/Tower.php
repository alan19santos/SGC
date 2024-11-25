<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tower extends Model
{
    use HasFactory;

    protected $table = 'tower';
    protected $fillable = ['name','capacity','type','condominium_id'];

    public function condominium(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Condominium::class, 'condominium_id', 'id');
    }
}
