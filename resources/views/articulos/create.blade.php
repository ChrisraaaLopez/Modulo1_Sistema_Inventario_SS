@extends('layouts.app')

@section('title', 'Nuevo artículo')

@section('content')
<h1>Nuevo artículo</h1>

<form action="{{ route('articulos.store') }}" method="POST" class="mt-3">
    @csrf

    <div class="mb-3">
        <label class="form-label">Descripción:</label>
        <input type="text" name="Descripcion" value="{{ old('Descripcion') }}" class="form-control" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Marca:</label>
            <select id="marca" name="FkId_Marca" class="form-select" required>
                <option value="">-- Selecciona una marca --</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->Id_Marca }}" {{ old('FkId_Marca') == $marca->Id_Marca ? 'selected' : '' }}>{{ $marca->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Modelo:</label>
            <select id="modelo" name="FkId_Modelo" class="form-select" required>
                <option value="">-- Selecciona primero una marca --</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Número de serie:</label>
            <input type="text" name="N_Serie" value="{{ old('N_Serie') }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Color:</label>
            <input type="text" name="Color" value="{{ old('Color') }}" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Categoría:</label>
            <select name="FkId_Categoria" class="form-select" required>
                <option value="">-- Selecciona una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->Id_Categoria }}" {{ old('FkId_Categoria') == $categoria->Id_Categoria ? 'selected' : '' }}>{{ $categoria->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo:</label>
            <select name="FkId_Tipo" class="form-select" required>
                <option value="">-- Selecciona un tipo --</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->Id_Tipo }}" {{ old('FkId_Tipo') == $tipo->Id_Tipo ? 'selected' : '' }}>{{ $tipo->Nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ubicación:</label>
            <select name="FkId_Ubicacion" class="form-select" required>
                <option value="">-- Selecciona una ubicación --</option>
                @foreach($ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->Id_Ubicacion }}" {{ old('FkId_Ubicacion') == $ubicacion->Id_Ubicacion ? 'selected' : '' }}>{{ $ubicacion->Nombre }} ({{ $ubicacion->Edificio }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Empleado responsable:</label>
            <select name="FkId_Empleado" class="form-select" required>
                <option value="">-- Selecciona un empleado --</option>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->Id_Empleado }}" {{ old('FkId_Empleado') == $empleado->Id_Empleado ? 'selected' : '' }}>{{ $empleado->Nombre }} {{ $empleado->Apellido_Paterno }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Factura (opcional):</label>
        <select name="FkId_Factura" class="form-select">
            <option value="">-- Sin factura --</option>
            @foreach($facturas as $factura)
                <option value="{{ $factura->Id_Factura }}" {{ old('FkId_Factura') == $factura->Id_Factura ? 'selected' : '' }}>{{ $factura->Folio }} — {{ $factura->Proveedor }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Estado:</label>
            <select name="Estado" class="form-select" required>
                <option value="Bien" {{ old('Estado') == 'Bien' ? 'selected' : '' }}>Bien</option>
                <option value="Reparacion" {{ old('Estado') == 'Reparacion' ? 'selected' : '' }}>Reparación</option>
                <option value="Dañado" {{ old('Estado') == 'Dañado' ? 'selected' : '' }}>Dañado</option>
                <option value="Obsoleto" {{ old('Estado') == 'Obsoleto' ? 'selected' : '' }}>Obsoleto</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo de artículo:</label>
            <select name="Tipo_Articulo" class="form-select" required>
                <option value="Capitalizable" {{ old('Tipo_Articulo') == 'Capitalizable' ? 'selected' : '' }}>Capitalizable</option>
                <option value="No Capitalizable" {{ old('Tipo_Articulo') == 'No Capitalizable' ? 'selected' : '' }}>No Capitalizable</option>
                <option value="Consumible" {{ old('Tipo_Articulo') == 'Consumible' ? 'selected' : '' }}>Consumible</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Notas:</label>
        <input type="text" name="Notas" value="{{ old('Notas') }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Comentarios:</label>
        <input type="text" name="Comentarios" value="{{ old('Comentarios') }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
document.getElementById('marca').addEventListener('change', function () {
    const marcaId = this.value;
    const modeloSelect = document.getElementById('modelo');
    modeloSelect.innerHTML = '<option value="">Cargando...</option>';

    if (!marcaId) {
        modeloSelect.innerHTML = '<option value="">-- Selecciona primero una marca --</option>';
        return;
    }

    fetch(`/modelos-por-marca/${marcaId}`)
        .then(res => res.json())
        .then(modelos => {
            modeloSelect.innerHTML = '<option value="">-- Selecciona un modelo --</option>';
            modelos.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.Id_Modelo;
                opt.textContent = m.Nombre;
                modeloSelect.appendChild(opt);
            });
        });
});
</script>
@endsection