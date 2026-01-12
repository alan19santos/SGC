<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {

        $profile = [
            [
                'name' => 'ADMINISTRADOR',
                'slug' => 'admin',
            ],
            [
                'name' => 'MASTER',
                'slug' => 'master',
            ],
            [
                'name' => 'MORADOR',
                'slug' => 'morador',
            ],
            [
                'name' => 'AUXILIAR',
                'slug' => 'auxiliar',
            ],
            [
                'name' => 'FUNCIONARIO',
                'slug' => 'funcionario'
            ],
        ];


        foreach ($profile as $dt) {
            Profile::updateOrCreate(['name' => $dt['name']],
                ['slug' => $dt['slug']]);
        }
    }
}
