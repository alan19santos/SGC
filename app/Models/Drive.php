<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;

    protected $table = 'drive';
    protected $fillable = ['description', 'plate_number', 'model' , 'color'];

    public function resident() {
        return $this->belongsToMany(Resident::class, 'drive_resident', 'drive_id', 'resident_id');
    }
}
