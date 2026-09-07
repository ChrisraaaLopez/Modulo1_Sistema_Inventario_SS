<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Categoria;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::with('categoria')->orderBy('Nombre')->paginate(15);
        return view('tipos.index', compact('tipos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('Nombre')->get();
        return view('tipos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:200',
            'FkId_Categoria' => 'required|exists:categorias,Id_Categoria',
        ]);

        Tipo::create($request->only('Nombre', 'FkId_Categoria'));

        return redirect()->route('tipos.index')->with('ok', 'Tipo registrado correctamente');
    }

    public function edit(Tipo $tipo)
    {
        $categorias = Categoria::orderBy('Nombre')->get();
        return view('tipos.edit', compact('tipo', 'categorias'));
    }

    public function update(Request $request, Tipo $tipo)
    {
        $request->validate([
            'Nombre' => 'required|string|max:200',
            'FkId_Categoria' => 'required|exists:categorias,Id_Categoria',
        ]);

        $tipo->update($request->only('Nombre', 'FkId_Categoria'));

        return redirect()->route('tipos.index')->with('ok', 'Tipo actualizado correctamente');
    }

    public function destroy(Tipo $tipo)
    {
        $tipo->delete();
        return redirect()->route('tipos.index')->with('ok', 'Tipo eliminado');
    }
}