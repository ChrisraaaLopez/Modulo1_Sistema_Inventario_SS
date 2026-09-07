<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->id('Id_Puesto');
            $table->string('Nombre', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};