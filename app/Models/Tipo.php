<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';
    protected $primaryKey = 'Id_Tipo';
    public $timestamps = false;

    protected $fillable = ['Nombre', 'FkId_Categoria'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'FkId_Categoria');
    }

    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'FkId_Tipo');
    }
}