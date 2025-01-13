<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    use HasFactory;

    protected $fillable = ['name',
    'tower',
    'date',
    'rg',
    'entry_time',
    'concierge_visa',
    'observation',
    'condominium_id'];
}
