@extends('layouts.app')

@section('title', 'Puestos')

@section('content')
<h1>Puestos</h1>

<a href="{{ route('puestos.create') }}" class="btn btn-primary mb-3">+ Nuevo puesto</a>

<table class="table table-bordered table-striped">
    <tr>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    @foreach($puestos as $puesto)
    <tr>
        <td>{{ $puesto->Nombre }}</td>
        <td>
            <a href="{{ route('puestos.edit', $puesto) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('puestos.destroy', $puesto) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este puesto?')">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $puestos->links() }}
@endsection