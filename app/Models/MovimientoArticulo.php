<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoArticulo extends Model
{
    protected $table = 'movimientos_articulos';

    protected $primaryKey = 'Id_Movimiento';

    public $timestamps = false;

    protected $fillable = [
        'FkId_Articulo',
        'FkId_Ubicacion_Origen',
        'FkId_Ubicacion_Destino',
        'FkId_Resguardo',
        'FkId_Usuario',
        'Fecha',
        'Motivo',
    ];

    protected $casts = ['Fecha' => 'datetime'];
}
