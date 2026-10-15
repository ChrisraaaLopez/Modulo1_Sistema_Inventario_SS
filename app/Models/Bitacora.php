<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = ['FkId_Usuario', 'Accion', 'Entidad', 'Id_Entidad', 'Detalle', 'Fecha'];

    protected $casts = ['Fecha' => 'datetime'];
}
