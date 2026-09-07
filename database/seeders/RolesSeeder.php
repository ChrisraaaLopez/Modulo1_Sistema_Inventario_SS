<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['Id_Rol' => 1, 'Nombre' => 'Administrador'],
            ['Id_Rol' => 2, 'Nombre' => 'Revisor'],
            ['Id_Rol' => 3, 'Nombre' => 'Consulta'],
        ]);
    }
}