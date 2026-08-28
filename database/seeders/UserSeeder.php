<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'USUARIO DE TESTE',
                'email' => 'USUARIOTESTE@SGC.COM.BR',
                'password' => Hash::make('sgc2026'),
                'profile_id' => 2
            ],
        ];
        User::insert($user);
    }
}