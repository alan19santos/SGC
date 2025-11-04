<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class SpaceReservation extends Model
{
    use HasFactory;

    protected $table = 'space_reservation';
    protected $fillable = ['date_reserved','time','observation','user_id','type_reserved_id','status_reserve_id'] ;


    public function user(): belongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }


    public function type(): BelongsTo {
        return $this->belongsTo(TypeReserved::class, 'type_reserved_id', 'id');
    }


    public function status(): BelongsTo {
        return $this->belongsTo(StatusReserve::class, 'status_reserve_id', 'id');
    }


}
