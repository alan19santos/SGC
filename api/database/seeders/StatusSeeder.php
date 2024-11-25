<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $status = [
            [
               'description' => 'Proprietario', 'slug' => 'proprietario',
            ],
            [
                'description' => 'Parentes/Proprietario', 'slug' => 'parentes_proprietario',
            ],
            [
                'description' => 'Inquilino', 'slug' => 'inquilino',
            ],
            [
                'description' => 'Parentes/Inquilino', 'slug' => 'parentes_inquilino',
            ],
        ];
        Status::insert($status);

    }
}
