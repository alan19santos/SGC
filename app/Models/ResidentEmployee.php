<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentEmployee extends Model
{
    use HasFactory;

    protected $table = 'resident_employee';

    protected $fillable = ['employee_id', 'resident_id'];
}
