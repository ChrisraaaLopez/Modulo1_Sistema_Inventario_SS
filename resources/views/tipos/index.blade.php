@extends('layouts.app')

@section('title', 'Tipos')

@section('content')
<h1>Tipos</h1>

<a href="{{ route('tipos.create') }}" class="btn btn-primary mb-3">+ Nuevo tipo</a>

<table class="table table-bordered table-striped">
    <tr>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Acciones</th>
    </tr>
    @foreach($tipos as $tipo)
    <tr>
        <td>{{ $tipo->Nombre }}</td>
        <td>{{ $tipo->categoria->Nombre }}</td>
        <td>
            <a href="{{ route('tipos.edit', $tipo) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('tipos.destroy', $tipo) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este tipo?')">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $tipos->links() }}
@endsection