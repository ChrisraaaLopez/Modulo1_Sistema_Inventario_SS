<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'Id_Factura';
    public $timestamps = false;

    protected $fillable = ['Folio', 'Fecha', 'Proveedor', 'Monto', 'Descripcion', 'URL_Factura'];

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'FkId_Factura');
    }
}