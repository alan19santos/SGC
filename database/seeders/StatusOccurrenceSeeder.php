<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusOccurrence;

class StatusOccurrenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
               'name' => 'Aberto', 'slug' => 'aberto',
            ],
            [
                'name' => 'Em Andamento', 'slug' => 'em_andamento',
            ],
            [
                'name' => 'Aguardando Aprovação', 'slug' => 'aguardando_aprovacao',
            ],
            [
                'name' => 'Cancelado', 'slug' => 'cancelado',
            ],
            [
                'name' => 'Concluído', 'slug' => 'concluido',
            ],

        ];

        foreach ($status as $st) {
            StatusOccurrence::updateOrCreate(['name' => $st['name']],$st);
        }
    }
}
