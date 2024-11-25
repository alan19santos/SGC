<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = ['name','type','tower_id'];

    protected $table = 'apartment';

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id' , 'id');
    }
}
