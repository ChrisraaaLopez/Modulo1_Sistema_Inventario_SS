<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index()
    {
        $puestos = Puesto::where('Estatus', 'Activo')->orderBy('Nombre')->paginate(15);
        return view('puestos.index', compact('puestos'));
    }

    public function create()
    {
        return view('puestos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Estatus' => 'required|in:Activo,Inactivo',
        ]);

        Puesto::create($request->only('Nombre', 'Estatus'));

        return redirect()->route('puestos.index')->with('ok', 'Puesto registrado correctamente');
    }

    public function edit(Puesto $puesto)
    {
        return view('puestos.edit', compact('puesto'));
    }

    public function update(Request $request, Puesto $puesto)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Estatus' => 'required|in:Activo,Inactivo',
        ]);

        $puesto->update($request->only('Nombre', 'Estatus'));

        return redirect()->route('puestos.index')->with('ok', 'Puesto actualizado correctamente');
    }

    public function destroy(Puesto $puesto)
    {
        $puesto->update(['Estatus' => 'Inactivo']);
        return redirect()->route('puestos.index')->with('ok', 'Puesto dado de baja correctamente');
    }
}