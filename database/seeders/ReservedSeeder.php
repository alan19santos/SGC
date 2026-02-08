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
            ["name"=> "Salão de Festa", "description"=> "Frigobar, Forno, Microondas, Churrasqueira"],
            ["name"=> "Piscina", "description" => "Cadeiras, Mesas, Guarda-Sol"],
            ["name"=> "Churrasqueira", "description" => "Completa"],
            ["name"=> "Campo de Futebol", "description" => "Sintetico, quadra de areia, etc.."],
        ];


        TypeReserved::insert($data);
    }
}
