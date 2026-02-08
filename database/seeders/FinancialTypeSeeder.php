<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialType;

class FinancialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
               'name' => 'Manutenção', 'slug' => 'manutencao',
            ],
            [
                'name' => 'Taxa Condominio', 'slug' => 'taxa_condominio',
            ],
            [
                'name' => 'Serviços Terceiros', 'slug' => 'servicos_terceiros',
            ],
            [
                'name' => 'Salários', 'slug' => 'salarios',
            ],
            [
                'name' => 'Outros', 'slug' => 'outros',
            ],
            [
                'name' => 'Multa Aplicada', 'slug' => 'multa_aplicada',
            ],

        ];

        foreach ($data as $dt) {
            FinancialType::updateOrCreate(['name' => $dt['name']],$dt);
        }
    }
}
