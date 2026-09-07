<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Marca;
use App\Models\Tipo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index()
    {
        $modelos = Modelo::with(['marca', 'tipo'])->orderBy('Nombre')->paginate(15);
        return view('modelos.index', compact('modelos'));
    }

    public function create()
    {
        $marcas = Marca::orderBy('Nombre')->get();
        $tipos = Tipo::orderBy('Nombre')->get();
        return view('modelos.create', compact('marcas', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'FkId_Marca' => 'required|exists:marcas,Id_Marca',
            'FkId_Tipo' => 'required|exists:tipos,Id_Tipo',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('Nombre', 'FkId_Marca', 'FkId_Tipo');

        if ($request->hasFile('imagen')) {
            $data['URL_Imagen'] = $request->file('imagen')->store('modelos', 'public');
        }

        Modelo::create($data);

        return redirect()->route('modelos.index')->with('ok', 'Modelo registrado correctamente');
    }

    public function edit(Modelo $modelo)
    {
        $marcas = Marca::orderBy('Nombre')->get();
        $tipos = Tipo::orderBy('Nombre')->get();
        return view('modelos.edit', compact('modelo', 'marcas', 'tipos'));
    }

    public function update(Request $request, Modelo $modelo)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'FkId_Marca' => 'required|exists:marcas,Id_Marca',
            'FkId_Tipo' => 'required|exists:tipos,Id_Tipo',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('Nombre', 'FkId_Marca', 'FkId_Tipo');

        if ($request->hasFile('imagen')) {
            $data['URL_Imagen'] = $request->file('imagen')->store('modelos', 'public');
        }

        $modelo->update($data);

        return redirect()->route('modelos.index')->with('ok', 'Modelo actualizado correctamente');
    }

    public function destroy(Modelo $modelo)
    {
        $modelo->delete();
        return redirect()->route('modelos.index')->with('ok', 'Modelo eliminado');
    }

    // RF-04: filtro dependiente marca -> modelo, usado por el formulario de Artículos más adelante
    public function porMarca(Marca $marca)
    {
        return $marca->modelos()->select('Id_Modelo', 'Nombre')->orderBy('Nombre')->get();
    }
}