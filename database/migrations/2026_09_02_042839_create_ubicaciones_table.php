<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id('Id_Ubicacion');
            $table->string('Nombre', 100);
            $table->string('Edificio', 10);
            $table->string('Planta', 10);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};