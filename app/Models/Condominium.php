<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominium extends Model
{
    use HasFactory;

    protected $table = 'condominium';
    protected $fillable = ['name','address','city','qtd_tower','qtd_ap'];

    public function towers() {
        return $this->hasMany(Tower::class , 'condominium_id', 'id');
    }
}
