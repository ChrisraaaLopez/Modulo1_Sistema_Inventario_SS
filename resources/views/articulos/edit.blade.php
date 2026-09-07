@extends('layouts.app')

@section('title', 'Editar artículo')

@section('content')
<h1>Editar artículo</h1>

<form action="{{ route('articulos.update', $articulo) }}" method="POST" class="mt-3">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Descripción:</label>
        <input type="text" name="Descripcion" value="{{ old('Descripcion', $articulo->Descripcion) }}" class="form-control" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Marca:</label>
            <select id="marca" name="FkId_Marca" class="form-select" required>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->Id_Marca }}" {{ old('FkId_Marca', $articulo->FkId_Marca) == $marca->Id_Marca ? 'selected' : '' }}>{{ $marca->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Modelo:</label>
            <select id="modelo" name="FkId_Modelo" class="form-select" required>
                <option value="{{ $articulo->FkId_Modelo }}" selected>{{ $articulo->modelo->Nombre }}</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Número de serie:</label>
            <input type="text" name="N_Serie" value="{{ old('N_Serie', $articulo->N_Serie) }}" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Color:</label>
            <input type="text" name="Color" value="{{ old('Color', $articulo->Color) }}" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Categoría:</label>
            <select name="FkId_Categoria" class="form-select" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->Id_Categoria }}" {{ old('FkId_Categoria', $articulo->FkId_Categoria) == $categoria->Id_Categoria ? 'selected' : '' }}>{{ $categoria->Nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo:</label>
            <select name="FkId_Tipo" class="form-select" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->Id_Tipo }}" {{ old('FkId_Tipo', $articulo->FkId_Tipo) == $tipo->Id_Tipo ? 'selected' : '' }}>{{ $tipo->Nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ubicación:</label>
            <select name="FkId_Ubicacion" class="form-select" required>
                @foreach($ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->Id_Ubicacion }}" {{ old('FkId_Ubicacion', $articulo->FkId_Ubicacion) == $ubicacion->Id_Ubicacion ? 'selected' : '' }}>{{ $ubicacion->Nombre }} ({{ $ubicacion->Edificio }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Empleado responsable:</label>
            <select name="FkId_Empleado" class="form-select" required>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->Id_Empleado }}" {{ old('FkId_Empleado', $articulo->FkId_Empleado) == $empleado->Id_Empleado ? 'selected' : '' }}>{{ $empleado->Nombre }} {{ $empleado->Apellido_Paterno }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Factura (opcional):</label>
        <select name="FkId_Factura" class="form-select">
            <option value="">-- Sin factura --</option>
            @foreach($facturas as $factura)
                <option value="{{ $factura->Id_Factura }}" {{ old('FkId_Factura', $articulo->FkId_Factura) == $factura->Id_Factura ? 'selected' : '' }}>{{ $factura->Folio }} — {{ $factura->Proveedor }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Estado:</label>
            <select name="Estado" class="form-select" required>
                @foreach(['Bien', 'Reparacion', 'Dañado', 'Obsoleto'] as $e)
                    <option value="{{ $e }}" {{ old('Estado', $articulo->Estado) == $e ? 'selected' : '' }}>{{ $e }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Tipo de artículo:</label>
            @if(in_array($articulo->Tipo_Articulo, ['En Proceso de Baja', 'Baja']))
                <input type="text" class="form-control" value="{{ $articulo->Tipo_Articulo }}" disabled>
                <input type="hidden" name="Tipo_Articulo" value="{{ $articulo->Tipo_Articulo }}">
                <small class="text-muted">Este artículo está en proceso de baja. Solo el administrador puede reactivarlo.</small>
            @else
                <select name="Tipo_Articulo" class="form-select" required>
                    @foreach(['Capitalizable', 'No Capitalizable', 'Consumible'] as $t)
                        <option value="{{ $t }}" {{ old('Tipo_Articulo', $articulo->Tipo_Articulo) == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Notas:</label>
        <input type="text" name="Notas" value="{{ old('Notas', $articulo->Notas) }}" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Comentarios:</label>
        <input type="text" name="Comentarios" value="{{ old('Comentarios', $articulo->Comentarios) }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
document.getElementById('marca').addEventListener('change', function () {
    const marcaId = this.value;
    const modeloSelect = document.getElementById('modelo');
    modeloSelect.innerHTML = '<option value="">Cargando...</option>';

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