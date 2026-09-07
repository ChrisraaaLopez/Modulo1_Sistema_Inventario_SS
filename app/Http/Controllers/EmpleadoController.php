<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\Area;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with(['puesto', 'area'])->orderBy('Nombre')->paginate(15);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $puestos = Puesto::orderBy('Nombre')->get();
        $areas = Area::orderBy('Nombre')->get();
        return view('empleados.create', compact('puestos', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'N_Trabajador' => 'required|string|max:10|unique:empleados,N_Trabajador',
            'Nombre' => 'required|string|max:50',
            'Apellido_Paterno' => 'required|string|max:50',
            'Apellido_Materno' => 'nullable|string|max:50',
            'FkId_Puesto' => 'required|exists:puestos,Id_Puesto',
            'FkId_Area' => 'required|exists:areas,Id_Area',
            'Estatus' => 'required|in:Activo,Inactivo,Baja',
        ]);

        Empleado::create($request->only(
            'N_Trabajador', 'Nombre', 'Apellido_Paterno', 'Apellido_Materno',
            'FkId_Puesto', 'FkId_Area', 'Estatus'
        ));

        return redirect()->route('empleados.index')->with('ok', 'Empleado registrado correctamente');
    }

    public function edit(Empleado $empleado)
    {
        $puestos = Puesto::orderBy('Nombre')->get();
        $areas = Area::orderBy('Nombre')->get();
        return view('empleados.edit', compact('empleado', 'puestos', 'areas'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'N_Trabajador' => 'required|string|max:10|unique:empleados,N_Trabajador,' . $empleado->Id_Empleado . ',Id_Empleado',
            'Nombre' => 'required|string|max:50',
            'Apellido_Paterno' => 'required|string|max:50',
            'Apellido_Materno' => 'nullable|string|max:50',
            'FkId_Puesto' => 'required|exists:puestos,Id_Puesto',
            'FkId_Area' => 'required|exists:areas,Id_Area',
            'Estatus' => 'required|in:Activo,Inactivo,Baja',
        ]);

        $empleado->update($request->only(
            'N_Trabajador', 'Nombre', 'Apellido_Paterno', 'Apellido_Materno',
            'FkId_Puesto', 'FkId_Area', 'Estatus'
        ));

        return redirect()->route('empleados.index')->with('ok', 'Empleado actualizado correctamente');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('ok', 'Empleado eliminado');
    }
}