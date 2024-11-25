<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $fillable = ['name', 'cpf', 'rg'];

    public function resident(){
        return $this->belongsToMany(Resident::class, 'resident_employee', 'employee_id', 'resident_id');
    }
}
