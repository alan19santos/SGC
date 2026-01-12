<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEmployee extends Model
{
    use HasFactory;

    protected $table = 'type_employee';

    protected $fillable = ['name','slug'];
}
