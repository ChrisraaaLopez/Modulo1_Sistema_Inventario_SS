<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_articulos', function (Blueprint $table) {
            $table->id('Id_Movimiento');
            $table->foreignId('FkId_Articulo')->constrained('articulos', 'Id_Articulo')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('FkId_Ubicacion_Origen')->nullable()->constrained('ubicaciones', 'Id_Ubicacion')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('FkId_Ubicacion_Destino')->nullable()->constrained('ubicaciones', 'Id_Ubicacion')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('FkId_Resguardo')->nullable()->constrained('resguardos', 'Id_Resguardo')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('FkId_Usuario')->nullable()->constrained('usuarios', 'Id_Usuario')->nullOnDelete()->cascadeOnUpdate();
            $table->dateTime('Fecha')->nullable();
            $table->string('Motivo', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_articulos');
    }
};
