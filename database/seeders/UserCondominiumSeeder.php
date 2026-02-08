<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CondominiumUser;

class UserCondominiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $condominiumUsers = [
            [
                'user_id' => 1,
                'condominium_id' => 1
            ]
        ];

        CondominiumUser::insert($condominiumUsers);
    }
}
