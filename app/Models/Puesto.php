<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';
    protected $primaryKey = 'Id_Puesto';
    public $timestamps = false;

    protected $fillable = ['Nombre'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'FkId_Puesto');
    }
}