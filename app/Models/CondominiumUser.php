<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondominiumUser extends Model
{
    use HasFactory;

    protected $table = 'condominium_user';
    protected $fillable = [
        'condominium_id',
        'user_id',
    ];
}
