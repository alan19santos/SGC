<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusReserve;

class StatusReservedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $status = [
            [
               'name' => 'Aguardando', 'slug' => 'aguardando',
            ],
            [
                'name' => 'Ativo', 'slug' => 'ativo',
            ],
            [
                'name' => 'Inativo', 'slug' => 'inativo',
            ],

        ];

        foreach ($status as $st) {
            StatusReserve::updateOrCreate(['name' => $st['name']],['slug'=>$st['slug']]);
        }
    }
}
