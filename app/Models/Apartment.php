<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Apartment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name','type','tower_id', 'condominium_id'];

    protected $table = 'apartment';

    public function tower()
    {
        return $this->belongsTo(Tower::class, 'tower_id' , 'id');
    }

    public function condominium() {
        return $this->belongsTo(Condominium::class, 'condominium_id', 'id');
    }
}
