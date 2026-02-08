<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeService;

class TypeServiceseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name'=>'Limpeza', 'slug'=>'limpeza'
            ],
            [
                'name'=>'Internet', 'slug'=>'internet'
            ],
            [
                'name'=>'Eletrica', 'slug'=>'eletrica'
            ],
            [
                'name'=>'Capinagem', 'slug'=>'capinagem'
            ],
            [
                'name'=>'Condominio/Próprio', 'slug'=>'condominio_proprio'
            ],
        ];

        foreach ($types as $type) {
            TypeService::updateOrCreate(['name'=> $type['name']],
             ['slug'=>$type['slug']]);
        }
    }
}
