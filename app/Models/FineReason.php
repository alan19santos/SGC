<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FineReason extends Model
{
    use HasFactory;

    protected $table = 'fine_reason';

    protected $fillable = [
        'name',
        'slug',
    ];
}
