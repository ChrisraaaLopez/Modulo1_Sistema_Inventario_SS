<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['Id_Categoria' => 1, 'Nombre' => 'MOBILIARIO Y EQUIPO DE ADMINISTRACIÓN', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Categoria' => 2, 'Nombre' => 'EQUIPO DE CÓMPUTO Y DE TECNOLOGÍAS DE LA INFORMACIÓN', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Categoria' => 3, 'Nombre' => 'MOBILIARIO Y EQUIPO EDUCACIONAL Y RECREATIVO', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Categoria' => 4, 'Nombre' => 'EQUIPO E INSTRUMENTAL MEDICO Y DE LABORATORIO', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Categoria' => 5, 'Nombre' => 'MAQUINARIA, OTROS EQUIPOS Y HERRAMIENTAS', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Categoria' => 6, 'Nombre' => 'LICENCIAS INFORMATICAS E INTELECTUALES', 'status' => 'activo', 'Estatus' => 'Activo'],
            ['Id_Categoria' => 7, 'Nombre' => 'VEHICULOS Y EQUIPO DE TRANSPORTE', 'status' => 'inactivo', 'Estatus' => 'Inactivo'],
            ['Id_Categoria' => 8, 'Nombre' => 'EQUIPO DE DEFENSA Y SEGURIDAD', 'status' => 'activo', 'Estatus' => 'Activo'],
        ]);
    }
}