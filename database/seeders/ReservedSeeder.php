<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeReserved;

class ReservedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data =
        [
            ["name"=> "Salão de Festa", "description"=> ""],
            ["name"=> "Churrasqueira", "description" => ""],
            ["name"=> "Campo de Futebol", "description" => ""],
        ];


        TypeReserved::insert($data);
    }
}
