<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeEmployee;
class TypeEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Zelador',
                'slug' => 'zelador'
            ],
            [
                'name' => 'Porteiro',
                'slug' => 'porteiro'
            ],
            [
                'name' => 'Administrador de condomínio (empresa terceirizada)',
                'slug' => 'administrador_condominio_terceirizado'
            ],
            [
                'name' => 'Assistente administrativo',
                'slug' => 'assistente_administrativo'
            ],
            [
                'name' => 'Auxiliar de serviços gerais',
                'slug' => 'auxiliar_servicos_gerais'
            ],
            [
                'name' => 'Faxineiro(a)',
                'slug' => 'faxineiro'
            ],
            [
                'name' => 'Eletricista',
                'slug' => 'eletricista'
            ],
            [
                'name' => 'Jardineiro',
                'slug' => 'jardineiro'
            ],
            [
                'name' => 'Outros',
                'slug' => 'outros'
            ],
        ];
        foreach ($data as $dt) {
            TypeEmployee::updateOrCreate(['name' => $dt['name']],
                ['slug' => $dt['slug']]);
        }
    }
}
