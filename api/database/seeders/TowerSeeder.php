<?php

namespace Database\Seeders;

use App\Models\Tower;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tower = [
            [
                'name' => 'Blco 1',
                'capacity' => 20,
                'type' => '',
                'condominium_id' => 1,
            ],
            [
                'name' => 'Blco 2',
                'capacity' => 20,
                'type' => '',
                'condominium_id' => 1,
            ],
            [
                'name' => 'Blco 3',
                'capacity' => 20,
                'type' => '',
                'condominium_id' => 1,
            ],
        ];
        Tower::insert($tower);
    }
}
