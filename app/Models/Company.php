<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['isActive','responsible_name','observation','phone','email','type_service_id','cnpj','name_company','condominium_id'];
    protected $table = "company";

    public function typeService() {
        return $this->hasMany(TypeService::class, 'id','type_service_id');
    }

    public function condominium() {
        return $this->hasMany(Condominium::class, 'id','condominium_id');
    }
}
