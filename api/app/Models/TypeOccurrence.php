<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOccurrence extends Model
{
    use HasFactory;

    protected $table = 'type_occurrence';
    protected $fillable = ['description','slug'];
}
