<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Empleado;
use App\Models\Marca;
use App\Models\Factura;

class DashboardController extends Controller
{
    public function index()
    {
        $totales = [
            'articulos' => Articulo::count(),
            'empleados' => Empleado::count(),
            'marcas'    => Marca::count(),
            'facturas'  => Factura::count(),
        ];

        return view('dashboard', compact('totales'));
    }
}