@extends('layouts.app')

@section('title', 'Empleados')

@section('content')
<h1>Empleados</h1>

<a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">+ Nuevo empleado</a>

<table class="table table-bordered table-striped">
    <tr>
        <th>N° Trabajador</th>
        <th>Nombre completo</th>
        <th>Puesto</th>
        <th>Área</th>
        <th>Estatus</th>
        <th>Acciones</th>
    </tr>
    @foreach($empleados as $empleado)
    <tr>
        <td>{{ $empleado->N_Trabajador }}</td>
        <td>{{ $empleado->Nombre }} {{ $empleado->Apellido_Paterno }} {{ $empleado->Apellido_Materno }}</td>
        <td>{{ $empleado->puesto->Nombre }}</td>
        <td>{{ $empleado->area->Nombre }}</td>
        <td>
            <span class="badge bg-{{ $empleado->Estatus === 'Activo' ? 'success' : ($empleado->Estatus === 'Inactivo' ? 'warning' : 'danger') }}">
                {{ $empleado->Estatus }}
            </span>
        </td>
        <td>
            <a href="{{ route('empleados.edit', $empleado) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('empleados.destroy', $empleado) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este empleado?')">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $empleados->links() }}
@endsection