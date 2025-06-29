<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Resident extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'resident';
    protected $fillable = ['name','cpf','rg','birth_date','phone','user_id','apartment_id','tower_id','condominium_id','status_id','url_image'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function drive() {
        return $this->belongsToMany(Drive::class,'drive_resident','resident_id','drive_id');
    }

    public function animals() {
        return $this->belongsToMany(Animals::class, 'resident_animals', 'resident_id' , 'animal_id');
    }


    public function employee() {
        return $this->belongsToMany(Employee::class, 'resident_employee', 'resident_id','employee_id');
    }

    public function apartment() {
        return $this->belongsTo(Apartment::class, 'apartment_id', 'id');
    }

    public function condominium() {
        return $this->belongsTo(Condominium::class);
    }

}
