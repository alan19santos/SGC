<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class SpaceReservation extends Model
{
    use HasFactory;

    protected $table = 'space_reservation';
    protected $fillable = ['date_reserved','time','observation','user_id','type_reserved_id'] ;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function condominium(): BelongsTo {
        return $this->belongsTo(Condominium::class);
    }

    public function tipe(): BelongsTo {
        return $this->belongsTo(TypeReserved::class);
    }

    
}
