<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusReserve extends Model
{
    use HasFactory;

     protected $table = 'status_reserve';
    protected $fillable = ['name','slug'];
}
