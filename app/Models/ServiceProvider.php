<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;
    
    protected $table = "service_provider";
    protected $fillable = [
    'name',
    'unity_name',
    'date',
    'unity_tower',
    'entry_time',
    'drive',
    'plate',
    'rg',
    'departure_time',
    'concierge_visa'];
}
