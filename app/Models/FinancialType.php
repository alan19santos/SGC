<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialType extends Model
{
    use HasFactory;

    protected $table = 'financial_type';

    protected $fillable = [
        'name',
        'slug',
    ];
}
