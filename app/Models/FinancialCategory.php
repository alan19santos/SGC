<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialCategory extends Model
{
    use HasFactory;

    protected $table = 'financial_category';

    protected $fillable = [
        'name',
        'slug',
    ];
}
