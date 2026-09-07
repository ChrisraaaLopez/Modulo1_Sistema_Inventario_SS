@extends('layouts.app')

@section('title', 'Modelos')

@section('content')
<h1>Modelos</h1>

<a href="{{ route('modelos.create') }}" class="btn btn-primary mb-3">+ Nuevo modelo</a>

<table class="table table-bordered table-striped align-middle">
    <tr>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Tipo</th>
        <th>Acciones</th>
    </tr>
    @foreach($modelos as $modelo)
    <tr>
        <td>
            @if($modelo->URL_Imagen)
                <img src="{{ Storage::url($modelo->URL_Imagen) }}" width="60">
            @else
                <span class="text-muted">Sin imagen</span>
            @endif
        </td>
        <td>{{ $modelo->Nombre }}</td>
        <td>{{ $modelo->marca->Nombre }}</td>
        <td>{{ $modelo->tipo->Nombre }}</td>
        <td>
            <a href="{{ route('modelos.edit', $modelo) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('modelos.destroy', $modelo) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este modelo?')">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $modelos->links() }}
@endsection