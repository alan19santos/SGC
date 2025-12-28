<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePeople extends Model
{
    use HasFactory;

    protected $table = 'employee_peoples';
    protected $fillable = ['employee_id','people_id'];
}
