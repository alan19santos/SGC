<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $fillable = ['name', 'cpf', 'rg', 'people_id','photo','type_employee_id','users_id'];

    public function resident(){
        return $this->belongsToMany(Resident::class, 'resident_employee', 'employee_id', 'resident_id');
    }

    public function people() {
        return $this->hasMany(Peoples::class, 'people_id', 'id');
    }

    public function type() {
        return $this->hasMany(TypeEmployee::class, 'type_employee_id', 'id');
    }

    public function users() {
        return $this->hasMany(User::class, 'users_id','id');
    }
}
