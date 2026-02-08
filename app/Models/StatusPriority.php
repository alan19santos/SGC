<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPriority extends Model
{
    use HasFactory;

    protected $table = 'status_priority';
    protected $fillable = ['name','slug'];
}
