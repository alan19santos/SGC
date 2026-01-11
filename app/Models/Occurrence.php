<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    use HasFactory;

    protected $table = 'occurrence';
    protected $fillable = ['date_occurrence','observation','previsibles_days','condominium_id','resident_id','title','user_id','type_occurrence_id','isResolved','resolution', 'updated_at','created_at','status_occurrence_id'];


    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function typeOccurrence() {
        return $this->belongsTo(TypeOccurrence::class,'type_occurrence_id','id');
    }

    public function statusOcurrence() {
        return $this->belongsTo(StatusOccurrence::class , 'status_occurrence_id', 'id');
    }


}
