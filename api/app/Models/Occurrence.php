<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occurrence extends Model
{
    use HasFactory;

    protected $table = 'Occurrence';
    protected $fillable = ['date_occurrence','observation','title','user_id','type_occurrence_id','isResolved','resolution'];


    public function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function typeOccurrence() {
        return $this->belongsTo(TypeOccurrence::class,'type_occurrence_id','id');
    }
}
