@extends('layouts.app')

@section('title', 'Nuevo puesto')

@section('content')
<h1>Nuevo puesto</h1>

<form action="{{ route('puestos.store') }}" method="POST" class="mt-3">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="Nombre" value="{{ old('Nombre') }}" class="form-control" required placeholder="Ej. Coordinador de Laboratorio">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('puestos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection