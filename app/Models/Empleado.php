<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'Id_Empleado';
    public $timestamps = false;

    protected $fillable = [
        'N_Trabajador', 'Nombre', 'Apellido_Paterno', 'Apellido_Materno',
        'FkId_Puesto', 'FkId_Area', 'Estatus', 'status',
    ];

    public function setEstatusAttribute($value): void
    {
        $this->attributes['Estatus'] = $value;
        $this->attributes['status'] = is_string($value) ? strtolower($value) : $value;
    }

    public function setStatusAttribute($value): void
    {
        $this->attributes['status'] = $value;
        $this->attributes['Estatus'] = is_string($value) ? ucfirst(strtolower($value)) : $value;
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'FkId_Puesto');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'FkId_Area');
    }

    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'FkId_Empleado');
    }
}