<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialCategory;

class FinancialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
               'name' => 'Receita', 'slug' => 'receita',
            ],
            [
                'name' => 'Despesa', 'slug' => 'despesa',
            ],
        ];

        foreach ($data as $dt) {
            FinancialCategory::updateOrCreate(['name' => $dt['name']],$dt);
        }
    }
}
