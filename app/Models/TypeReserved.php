<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeReserved extends Model
{
    use HasFactory;

    protected $table = "type_reserved";
    protected $fillable = ['description','name'] ;
}
