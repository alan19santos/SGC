<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOccurrence extends Model
{
    use HasFactory;

    protected $table = 'status_occurrence';
    protected $fillable = ['name','slug'];
}
