<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('areas')->insert([
            ['Id_Area' => 1, 'Nombre' => 'Dirección'],
            ['Id_Area' => 2, 'Nombre' => 'Administración'],
            ['Id_Area' => 3, 'Nombre' => 'Académica'],
            ['Id_Area' => 4, 'Nombre' => 'Planeación y Vinculación'],
            ['Id_Area' => 5, 'Nombre' => 'Control Escolar'],
            ['Id_Area' => 6, 'Nombre' => 'TICS'],
        ]);
    }
}