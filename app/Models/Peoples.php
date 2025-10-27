<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peoples extends Model
{
    use HasFactory;

    protected $fillable = ['name','cpf','rg','date_birth','email','drive_id','photo'];


    public function drive() {
        return $this->belongsToMany(Drive::class,'drive_people','people_id','drive_id');
    }

    // public function drive() {
    //     return $this->belongsToMany(Drive::class,'drive_resident','resident_id','drive_id');
    // }


}
