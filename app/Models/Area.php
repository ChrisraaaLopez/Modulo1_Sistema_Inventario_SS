<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'Id_Area';
    public $timestamps = false;

    protected $fillable = ['Nombre'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'FkId_Area');
    }
}