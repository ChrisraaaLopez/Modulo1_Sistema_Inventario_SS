@extends('layouts.app')

@section('title', 'Editar modelo')

@section('content')
<h1>Editar modelo</h1>

<form action="{{ route('modelos.update', $modelo) }}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nombre del modelo:</label>
        <input type="text" name="Nombre" value="{{ old('Nombre', $modelo->Nombre) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Marca:</label>
        <select name="FkId_Marca" class="form-select" required>
            @foreach($marcas as $marca)
                <option value="{{ $marca->Id_Marca }}" {{ old('FkId_Marca', $modelo->FkId_Marca) == $marca->Id_Marca ? 'selected' : '' }}>
                    {{ $marca->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Tipo:</label>
        <select name="FkId_Tipo" class="form-select" required>
            @foreach($tipos as $tipo)
                <option value="{{ $tipo->Id_Tipo }}" {{ old('FkId_Tipo', $modelo->FkId_Tipo) == $tipo->Id_Tipo ? 'selected' : '' }}>
                    {{ $tipo->Nombre }}
                </option>
            @endforeach
        </select>
    </div>

    @if($modelo->URL_Imagen)
        <div class="mb-3">
            <label class="form-label d-block">Imagen actual:</label>
            <img src="{{ Storage::url($modelo->URL_Imagen) }}" width="120">
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label">Reemplazar imagen (opcional):</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('modelos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection