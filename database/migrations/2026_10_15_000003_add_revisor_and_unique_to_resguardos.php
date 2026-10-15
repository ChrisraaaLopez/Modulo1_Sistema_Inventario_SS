<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('resguardos', 'FkId_Usuario_Revisor')) {
            Schema::table('resguardos', function (Blueprint $table) {
                $table->foreignId('FkId_Usuario_Revisor')->nullable()->after('FkId_Empleado')->constrained('usuarios', 'Id_Usuario')->nullOnDelete()->cascadeOnUpdate();
            });
        }

        $duplicados = DB::table('resguardos')
            ->select('FkId_Periodo', 'FkId_Ubicacion', DB::raw('COUNT(*) as total'))
            ->groupBy('FkId_Periodo', 'FkId_Ubicacion')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if ($duplicados->isNotEmpty()) {
            $mensaje = $duplicados->map(fn ($registro) => 'periodo='.$registro->FkId_Periodo.' ubicacion='.$registro->FkId_Ubicacion.' total='.$registro->total)->implode('; ');
            throw new RuntimeException('Se detectaron duplicados previos en resguardos: '.$mensaje);
        }

        if (! Schema::hasColumn('resguardos', 'FkId_Usuario_Revisor') || ! Schema::hasIndex('resguardos', ['FkId_Periodo', 'FkId_Ubicacion'])) {
            Schema::table('resguardos', function (Blueprint $table) {
                $table->unique(['FkId_Periodo', 'FkId_Ubicacion'], 'resguardos_periodo_ubicacion_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('resguardos', function (Blueprint $table) {
            $table->dropUnique('resguardos_periodo_ubicacion_unique');
            $table->dropConstrainedForeignId('FkId_Usuario_Revisor');
        });
    }
};
