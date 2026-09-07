@extends('layouts.app')

@section('title', 'Marcas')

@section('content')
<h1>Marcas</h1>

<a href="{{ route('marcas.create') }}" class="btn btn-primary mb-3">+ Nueva marca</a>

<table class="table table-bordered table-striped">
    <tr>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    @foreach($marcas as $marca)
    <tr>
        <td>{{ $marca->Nombre }}</td>
        <td>
            <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('marcas.destroy', $marca) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta marca?')">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $marcas->links() }}
@endsection