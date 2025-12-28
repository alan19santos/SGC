<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeOccurrence;

class TypeOccurrenceSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $status = [
            [
                'description' => 'Reclamação',
                'slug' => 'reclamacao',
            ],
            [
                'description' => 'Reparo',
                'slug' => 'reparo',
            ],
            [
                'description' => 'Denúncia',
                'slug' => 'denuncia',
            ],
            ['description' => 'Barulho', 'slug' => 'barulho'],
            ['description' => 'Vazamento', 'slug' => 'vazamento'],
            ['description' => 'Manutenção', 'slug' => 'manutencao'],
            ['description' => 'Sugestão', 'slug' => 'sugestao'],
            ['description' => 'Segurança', 'slug' => 'seguranca'],
            ['description' => 'Outros', 'slug' => 'outros'],

        ];
        foreach ($status as $type) {
            TypeOccurrence::updateOrCreate(
                ['description' => $type['description']],
                ['slug' => $type['slug']]
            );
        }

    }
}
