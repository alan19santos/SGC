<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricOccurrence extends Model
{
    use HasFactory;

    protected $table = "history_occurrence";

    protected $fillable = ['observations', 'occurrence_id'];
}
