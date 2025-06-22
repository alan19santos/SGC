<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\TypeOccurrence;

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
               'description' => 'Reclamação', 'slug' => 'reclamacao',
            ],
            [
                'description' => 'Reparo', 'slug' => 'reparo',
            ],
            [
                'description' => 'Denúncia', 'slug' => 'denuncia',
            ],
           
        ];
        
        TypeOccurrence::insert($status);
    }
}
