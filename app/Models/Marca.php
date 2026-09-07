<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    protected $primaryKey = 'Id_Marca';
    public $timestamps = false;

    protected $fillable = ['Nombre'];

    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'FkId_Marca');
    }
}