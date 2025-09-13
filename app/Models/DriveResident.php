<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriveResident extends Model
{
    use HasFactory, softDeletes ;

    protected $table = 'drive_resident';
    protected $fillable = ['resident_id','drive_id'];



}
