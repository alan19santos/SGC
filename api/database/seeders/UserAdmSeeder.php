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
                'email' => 'ADMINISTRADOR@SAUDE.BA.GOV.BR',
                'password' => Hash::make('123456')
            ],
        ];
        User::insert($user);
    }
}
