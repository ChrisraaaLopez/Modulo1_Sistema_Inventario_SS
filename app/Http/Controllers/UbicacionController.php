<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::orderBy('Edificio')->orderBy('Nombre')->paginate(15);
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    public function create()
    {
        return view('ubicaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Edificio' => 'required|string|max:10',
            'Planta' => 'required|string|max:10',
        ]);

        Ubicacion::create($request->only('Nombre', 'Edificio', 'Planta'));

        return redirect()->route('ubicaciones.index')->with('ok', 'Ubicación registrada correctamente');
    }

    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicaciones.edit', compact('ubicacion'));
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Edificio' => 'required|string|max:10',
            'Planta' => 'required|string|max:10',
        ]);

        $ubicacion->update($request->only('Nombre', 'Edificio', 'Planta'));

        return redirect()->route('ubicaciones.index')->with('ok', 'Ubicación actualizada correctamente');
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return redirect()->route('ubicaciones.index')->with('ok', 'Ubicación eliminada');
    }
}