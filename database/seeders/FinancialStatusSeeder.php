<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialStatus;
class FinancialStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
               'name' => 'Pendente', 'slug' => 'pendente',
            ],
            [
                'name' => 'Pago', 'slug' => 'pago',
            ],
            [
                'name' => 'Isento', 'slug' => 'isento',
            ],
        ];

        foreach ($data as $dt) {
            FinancialStatus::updateOrCreate(['name' => $dt['name']],$dt);
        }
    }
}
