<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('FkId_Usuario')->nullable()->constrained('usuarios', 'Id_Usuario')->nullOnDelete()->cascadeOnUpdate();
            $table->string('Accion', 60);
            $table->string('Entidad', 60);
            $table->unsignedBigInteger('Id_Entidad')->nullable();
            $table->text('Detalle')->nullable();
            $table->dateTime('Fecha')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
