<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UsuariosRolesSeeder extends Seeder {
    public function run(): void {
        foreach (['Administrador','Revisor','Consulta'] as $nombre) {
            if (!DB::table('roles')->where('Nombre', $nombre)->exists()) {
                DB::table('roles')->insert(['Nombre' => $nombre]);
            }
        }
        $roles = DB::table('roles')->pluck('Id_Rol','Nombre');
        foreach ([['Osvaldo','Administrador'], ['Christian','Administrador'],['Emiliano','Revisor'],['Jhonatan','Consulta']] as [$usuario,$rol]) {
            if (DB::table('usuarios')->where('Nombre_Usuario', $usuario)->exists()) continue;
            $password = env('SEED_PASSWORD') ?: Str::random(12);
            DB::table('usuarios')->insert([
                'Nombre_Usuario'=>$usuario, 'Password_Hash'=>Hash::make($password),
                'FkId_Rol'=>$roles[$rol], 'Estatus'=>'Activo',
                'Fecha_Creacion'=>now(), 'Ultimo_Acceso'=>null,
            ]);
            $this->command?->warn("Usuario $usuario ($rol) creado. Contraseña inicial: $password");
        }
    }
}