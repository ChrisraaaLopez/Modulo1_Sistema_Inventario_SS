@extends('layouts.app')

@section('title', 'Editar puesto')

@section('content')
<h1>Editar puesto</h1>

<form action="{{ route('puestos.update', $puesto) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="Nombre" value="{{ old('Nombre', $puesto->Nombre) }}" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('puestos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection