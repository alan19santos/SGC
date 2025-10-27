<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Drive extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'drive';
    protected $fillable = ['description', 'plate_number', 'model' , 'color'];

    public function resident() {
        return $this->belongsToMany(Resident::class, 'drive_resident', 'drive_id', 'resident_id');
    }

    public function people() {
        return $this->belongsToMany(Peoples::class, 'drive_people', 'drive_id', 'people_id');
    }
}
