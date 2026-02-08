<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusPriority;

class StatusPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
               'name' => 'Baixa', 'slug' => 'baixa',
            ],
            [
                'name' => 'Média', 'slug' => 'media',
            ],
            [
                'name' => 'Alta', 'slug' => 'alta',
            ],
            [
                'name' => 'Crítica', 'slug' => 'critica',
            ],


        ];

        foreach ($status as $st) {
            StatusPriority::updateOrCreate(['name' => $st['name']],$st);
        }
    }
}
