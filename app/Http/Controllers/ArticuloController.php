<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Tipo;
use App\Models\Ubicacion;
use App\Models\Empleado;
use App\Models\Factura;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index(Request $request)
{
    $articulos = Articulo::with(['marca', 'modelo', 'categoria', 'ubicacion', 'empleado'])
        ->where(function ($query) {
            $query->where('status', 'activo')->orWhere(function ($nestedQuery) {
                $nestedQuery->whereNull('status')->where('Estatus', 'Activo');
            });
        })
        ->when($request->ubicacion, fn($q) => $q->where('FkId_Ubicacion', $request->ubicacion))
        ->when($request->categoria, fn($q) => $q->where('FkId_Categoria', $request->categoria))
        ->when($request->tipo, fn($q) => $q->where('FkId_Tipo', $request->tipo))
        ->when($request->empleado, fn($q) => $q->where('FkId_Empleado', $request->empleado))
        ->when($request->estado, fn($q) => $q->where('Estado', $request->estado))
        ->orderBy('Descripcion')
        ->paginate(15)
        ->withQueryString();

    $ubicaciones = Ubicacion::orderBy('Nombre')->get();
    $categorias = Categoria::orderBy('Nombre')->get();
    $tipos = Tipo::orderBy('Nombre')->get();
    $empleados = Empleado::orderBy('Nombre')->get();

    return view('articulos.index', compact('articulos', 'ubicaciones', 'categorias', 'tipos', 'empleados'));
}

    public function create()
    {
        return view('articulos.create', $this->catalogos());
    }

    public function store(Request $request)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:200',
            'FkId_Marca' => 'required|exists:marcas,Id_Marca',
            'FkId_Modelo' => 'required|exists:modelos,Id_Modelo',
            'N_Serie' => 'nullable|string|max:30',
            'Color' => 'nullable|string|max:100',
            'FkId_Categoria' => 'required|exists:categorias,Id_Categoria',
            'FkId_Tipo' => 'required|exists:tipos,Id_Tipo',
            'FkId_Ubicacion' => 'required|exists:ubicaciones,Id_Ubicacion',
            'FkId_Empleado' => 'required|exists:empleados,Id_Empleado',
            'FkId_Factura' => 'nullable|exists:facturas,Id_Factura',
            'Notas' => 'nullable|string|max:200',
            'Comentarios' => 'nullable|string|max:200',
            'Estado' => 'required|in:Bien,Reparacion,Dañado,Obsoleto',
            'Tipo_Articulo' => 'required|in:Capitalizable,No Capitalizable,Consumible,En Proceso de Baja,Baja',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(
            'Descripcion', 'FkId_Marca', 'FkId_Modelo', 'N_Serie', 'Color',
            'FkId_Categoria', 'FkId_Tipo', 'FkId_Ubicacion', 'FkId_Empleado',
            'FkId_Factura', 'Notas', 'Comentarios', 'Estado', 'Tipo_Articulo'
        );

        if ($request->hasFile('imagen')) {
            $data['URL_Imagen'] = $request->file('imagen')->store('articulos', 'public');
        }

        Articulo::create($data);

        return redirect()->route('articulos.index')->with('ok', 'Artículo registrado correctamente');
    }

    public function show(Articulo $articulo)
    {
        $articulo->load(['marca', 'modelo', 'categoria', 'tipo', 'ubicacion', 'empleado', 'factura']);
        return view('articulos.show', compact('articulo'));
    }

    public function edit(Articulo $articulo)
    {
        return view('articulos.edit', array_merge(['articulo' => $articulo], $this->catalogos()));
    }

    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:200',
            'FkId_Marca' => 'required|exists:marcas,Id_Marca',
            'FkId_Modelo' => 'required|exists:modelos,Id_Modelo',
            'N_Serie' => 'nullable|string|max:30',
            'Color' => 'nullable|string|max:100',
            'FkId_Categoria' => 'required|exists:categorias,Id_Categoria',
            'FkId_Tipo' => 'required|exists:tipos,Id_Tipo',
            'FkId_Ubicacion' => 'required|exists:ubicaciones,Id_Ubicacion',
            'FkId_Empleado' => 'required|exists:empleados,Id_Empleado',
            'FkId_Factura' => 'nullable|exists:facturas,Id_Factura',
            'Notas' => 'nullable|string|max:200',
            'Comentarios' => 'nullable|string|max:200',
            'Estado' => 'required|in:Bien,Reparacion,Dañado,Obsoleto',
            'Tipo_Articulo' => 'required|in:Capitalizable,No Capitalizable,Consumible,En Proceso de Baja,Baja',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(
            'Descripcion', 'FkId_Marca', 'FkId_Modelo', 'N_Serie', 'Color',
            'FkId_Categoria', 'FkId_Tipo', 'FkId_Ubicacion', 'FkId_Empleado',
            'FkId_Factura', 'Notas', 'Comentarios', 'Estado', 'Tipo_Articulo'
        );

        if ($request->hasFile('imagen')) {
            $data['URL_Imagen'] = $request->file('imagen')->store('articulos', 'public');
        }

        $articulo->update($data);

        return redirect()->route('articulos.index')->with('ok', 'Artículo actualizado correctamente');
    }

    // RF-03: baja de artículo (marca estado, no borra el registro)
    public function destroy(Request $request, Articulo $articulo)
{
    $request->validate([
        'Motivo' => 'nullable|string|max:300',
    ]);

    $articulo->update([
        'Tipo_Articulo' => 'En Proceso de Baja',
        'Estatus' => 'Inactivo',
        'status' => 'inactivo',
    ]);

    \App\Models\ArticuloBaja::create([
        'FkId_Articulo' => $articulo->Id_Articulo,
        'Fecha_Baja' => now()->toDateString(),
        'Motivo' => $request->input('Motivo'),
    ]);

    return redirect()->route('articulos.index')->with('ok', 'Artículo marcado como inactivo y registrado en el histórico de bajas');
}

    private function catalogos()
    {
        return [
            'marcas' => Marca::orderBy('Nombre')->get(),
            'categorias' => Categoria::orderBy('Nombre')->get(),
            'tipos' => Tipo::orderBy('Nombre')->get(),
            'ubicaciones' => Ubicacion::orderBy('Nombre')->get(),
            'empleados' => Empleado::orderBy('Nombre')->get(),
            'facturas' => Factura::orderBy('Folio')->get(),
        ];
    }
}