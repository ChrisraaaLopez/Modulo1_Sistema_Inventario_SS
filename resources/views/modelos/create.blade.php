@extends('layouts.app')

@section('title', 'Nuevo modelo')

@section('content')
<h1>Nuevo modelo</h1>

<form action="{{ route('modelos.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nombre del modelo:</label>
        <input type="text" name="Nombre" value="{{ old('Nombre') }}" class="form-control" required placeholder="Ej. LaserJet Pro M404">
    </div>

    <div class="mb-3">
        <label class="form-label">Marca:</label>
        <select name="FkId_Marca" class="form-select" required>
            <option value="">-- Selecciona una marca --</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->Id_Marca }}" {{ old('FkId_Marca') == $marca->Id_Marca ? 'selected' : '' }}>
                    {{ $marca->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tipo:</label>
        <select name="FkId_Tipo" class="form-select" required>
            <option value="">-- Selecciona un tipo --</option>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->Id_Tipo }}" {{ old('FkId_Tipo') == $tipo->Id_Tipo ? 'selected' : '' }}>
                    {{ $tipo->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Imagen de referencia (opcional):</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('modelos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection