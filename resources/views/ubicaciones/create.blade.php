@extends('layouts.app')

@section('title', 'Nueva ubicación')

@section('content')
<h1>Nueva ubicación</h1>

<form action="{{ route('ubicaciones.store') }}" method="POST" class="mt-3">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nombre:</label>
        <input type="text" name="Nombre" value="{{ old('Nombre') }}" class="form-control" required placeholder="Ej. Laboratorio de Cómputo">
    </div>
    <div class="mb-3">
        <label class="form-label">Edificio:</label>
        <input type="text" name="Edificio" value="{{ old('Edificio') }}" class="form-control" required placeholder="Ej. E">
    </div>
    <div class="mb-3">
        <label class="form-label">Planta:</label>
        <input type="text" name="Planta" value="{{ old('Planta') }}" class="form-control" required placeholder="Ej. 2">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('ubicaciones.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection