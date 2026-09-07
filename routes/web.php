<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ArticuloController;

Route::get('/', function () {
    return view('welcome');
});

//Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

//Ruta de Marcas
Route::resource('marcas', MarcaController::class)->parameters(['marcas' => 'marca']);

//Ruta de Tipos
Route::resource('tipos', TipoController::class)->parameters(['tipos' => 'tipo']);

//Ruta de Ubicaciones
Route::resource('ubicaciones', UbicacionController::class)
    ->parameters(['ubicaciones' => 'ubicacion']);

//Ruta de Puestos
Route::resource('puestos', PuestoController::class)
    ->parameters(['puestos' => 'puesto']);

//Ruta de Empleados
Route::resource('empleados', EmpleadoController::class)
    ->parameters(['empleados' => 'empleado']);

//Ruta(s) de Modelo
Route::resource('modelos', ModeloController::class)
    ->parameters(['modelos' => 'modelo']);

Route::get('/modelos-por-marca/{marca}', [ModeloController::class, 'porMarca'])->name('modelos.porMarca');

//Rutas de Factura
Route::resource('facturas', FacturaController::class)
    ->parameters(['facturas' => 'factura']);

//Rutas de Articulo
Route::resource('articulos', ArticuloController::class)
    ->parameters(['articulos' => 'articulo']);