<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeAccount;

class TypeAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Conta Corrente',
                'slug' => 'conta_corrente'
            ],
            [
                'name' => 'Conta Poupança',
                'slug' => 'conta_poupanca',

            ],
            [
                'name' => 'Conta Salário',
                'slug' => 'conta_salario',

            ],
            [

                'name' => 'Conta Digital',
                'slug' => 'conta_digital',
            ],

        ];

        foreach ($data as $dt) {
            TypeAccount::updateOrCreate(['name' => $dt['name']],
                ['slug' => $dt['slug']]);
        }
    }
}
