<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peoples extends Model
{
    use HasFactory;

    protected $fillable = ['name','cpf','rg','date_birth','email','drive_id','photo','phone','emergency_contact','responsible_tecnic','field_expertise', 'type_people','address','observation'];


    public function drive() {
        return $this->belongsToMany(Drive::class,'drive_people','people_id','drive_id');
    }

    public function employeer() {
        return $this->belongsToMany(Employee::class, 'employee_peoples','people_id','employee_id');
    }

    public function bank() {
        return $this->hasOne(BankAccount::class, 'people_id', 'id');
    }

}
