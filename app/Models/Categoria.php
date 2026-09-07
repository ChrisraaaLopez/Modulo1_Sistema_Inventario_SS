<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'Id_Categoria';
    public $timestamps = false;

    protected $fillable = ['Nombre'];

    public function tipos()
    {
        return $this->hasMany(Tipo::class, 'FkId_Categoria');
    }
}