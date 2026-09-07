<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['Id_Categoria' => 1, 'Nombre' => 'MOBILIARIO Y EQUIPO DE ADMINISTRACIÓN'],
            ['Id_Categoria' => 2, 'Nombre' => 'EQUIPO DE CÓMPUTO Y DE TECNOLOGÍAS DE LA INFORMACIÓN'],
            ['Id_Categoria' => 3, 'Nombre' => 'MOBILIARIO Y EQUIPO EDUCACIONAL Y RECREATIVO'],
            ['Id_Categoria' => 4, 'Nombre' => 'EQUIPO E INSTRUMENTAL MEDICO Y DE LABORATORIO'],
            ['Id_Categoria' => 5, 'Nombre' => 'MAQUINARIA, OTROS EQUIPOS Y HERRAMIENTAS'],
            ['Id_Categoria' => 6, 'Nombre' => 'LICENCIAS INFORMATICAS E INTELECTUALES'],
            ['Id_Categoria' => 7, 'Nombre' => 'VEHICULOS Y EQUIPO DE TRANSPORTE'],
            ['Id_Categoria' => 8, 'Nombre' => 'EQUIPO DE DEFENSA Y SEGURIDAD'],
        ]);
    }
}