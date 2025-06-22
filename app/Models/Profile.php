<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'slug'];

    public function user() {
        return $this->belongsToMany(User::class, 'users_profiles', 'user_id', 'profile_id');
    }
}
