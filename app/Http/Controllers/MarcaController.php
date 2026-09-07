<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::orderBy('Nombre')->paginate(15);
        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
        ]);

        Marca::create($request->only('Nombre'));

        return redirect()->route('marcas.index')->with('ok', 'Marca registrada correctamente');
    }

    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
        ]);

        $marca->update($request->only('Nombre'));

        return redirect()->route('marcas.index')->with('ok', 'Marca actualizada correctamente');
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();
        return redirect()->route('marcas.index')->with('ok', 'Marca eliminada');
    }
}