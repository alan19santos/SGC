<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'ADMINISTRADOR GERAL',
                'email' => 'ADMINISTRADOR@SGC.COM.BR',
                'password' => Hash::make('123456'),
                'profile_id' => 1
            ],
        ];
        User::insert($user);
    }
}
