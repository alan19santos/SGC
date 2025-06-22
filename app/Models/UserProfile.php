<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = 'users_profiles';
    protected $fillable = ['profile_id', 'user_id'];


    public function profile() {
        return $this->hasMany(Profile::class, 'id', 'profile_id');
    }

    public function user() {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}
