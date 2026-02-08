<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FineReason;

class FineReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
               'name' => 'Barulho após horário', 'slug' => 'barulho',
            ],
            [
                'name' => 'Uso indevido da infraestrutura', 'slug' => 'uso_indevido_infraestrutura',
            ],
            [
                'name' => 'Outros', 'slug' => 'outros',
            ],
            [
                'name' => 'Estacionamento em local proibido', 'slug' => 'estacionamento_proibido',
            ],
            [
                'name' => 'Desrespeito às normas do condomínio', 'slug' => 'desrespeito_normas_condominio',
            ],
            [
                'name' => 'Danos à propriedade comum', 'slug' => 'danos_propriedade_comum',
            ],
            [
                'name' => 'Animal solto', 'slug' => 'animal_solto',
            ]
        ];

        foreach ($data as $dt) {
            FineReason::updateOrCreate(['name' => $dt['name']],$dt);
        }
    }
}
