<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('areas')->insert([
            ['Id_Area' => 1, 'Nombre' => 'Dirección', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Area' => 2, 'Nombre' => 'Administración', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Area' => 3, 'Nombre' => 'Académica', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Area' => 4, 'Nombre' => 'Planeación y Vinculación', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Area' => 5, 'Nombre' => 'Control Escolar', 'status' => 'inactivo', 'Estatus' => 'Inactivo'],
            ['Id_Area' => 6, 'Nombre' => 'TICS', 'status' => 'activo', 'Estatus' => 'Activo'],
        ]);
    }
}