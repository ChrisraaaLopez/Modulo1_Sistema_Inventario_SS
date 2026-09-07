@extends('layouts.app')

@section('title', 'Editar marca')

@section('content')
<h1>Editar marca</h1>

<form action="{{ route('marcas.update', $marca) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="Nombre" value="{{ old('Nombre', $marca->Nombre) }}" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection