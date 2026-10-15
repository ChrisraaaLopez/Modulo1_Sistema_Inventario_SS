<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resguardo extends Model
{
    protected $table = 'resguardos';

    protected $primaryKey = 'Id_Resguardo';

    public $timestamps = false;

    protected $fillable = ['FkId_Periodo', 'FkId_Empleado', 'FkId_Ubicacion', 'FkId_Usuario_Revisor', 'Fecha_Firma', 'Fecha_Cierre', 'Cerrado', 'Observaciones'];

    protected $casts = ['Fecha_Firma' => 'date', 'Fecha_Cierre' => 'datetime', 'Cerrado' => 'boolean'];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'FkId_Periodo', 'Id_Periodo');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'FkId_Empleado', 'Id_Empleado');
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'FkId_Ubicacion', 'Id_Ubicacion');
    }

    public function articulos()
    {
        return $this->hasMany(ResguardoArticulo::class, 'FkId_Resguardo', 'Id_Resguardo');
    }

    public function revisor()
    {
        return $this->belongsTo(Usuario::class, 'FkId_Usuario_Revisor', 'Id_Usuario');
    }

    public function estaBloqueado(): bool
    {
        if ($this->Cerrado) {
            return true;
        }

        $periodo = $this->relationLoaded('periodo') ? $this->periodo : $this->periodo()->first();

        return $periodo && $periodo->Estado === 'Cerrado';
    }
}
