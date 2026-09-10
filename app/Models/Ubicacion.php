<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'Id_Ubicacion';
    public $timestamps = false;

    protected $fillable = ['Nombre', 'Edificio', 'Planta', 'Estatus'];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'FkId_Ubicacion');
    }
}