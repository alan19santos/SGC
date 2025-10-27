<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DrivePeople extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

     protected $table = 'drive_people';
    protected $fillable = ['drive_id', 'people_id'];



}
