@extends('layouts.app')

@section('title', 'Nuevo artículo')

@section('content')
<h1>Nuevo artículo</h1>

<form action="{{ route('articulos.store') }}" method="POST" class="mt-3" enctype="multipart/form-data">
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

    <div class="mb-3">
        <label class="form-label">Imagen del artículo (opcional):</label>
        <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
            <input type="file" id="imagenArchivo" name="imagen" class="form-control" accept="image/*">
            <button type="button" id="btnTomarFoto" class="btn btn-outline-primary">Tomar foto</button>
            <button type="button" id="btnCancelarFoto" class="btn btn-outline-secondary d-none">Cancelar</button>
        </div>
        <div id="selectorCamaraWrap" class="mb-2 d-none">
            <label class="form-label small mb-1">Selecciona cámara:</label>
            <select id="selectorCamara" class="form-select" style="max-width: 320px;"></select>
        </div>
        <video id="videoCamara" class="d-none border rounded" autoplay playsinline muted style="max-width: 320px; width: 100%;"></video>
        <canvas id="canvasFoto" class="d-none"></canvas>
        <div id="previewFoto" class="d-none mt-2">
            <img id="fotoPreview" src="" alt="Vista previa" class="img-thumbnail" style="max-width: 220px;">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('articulos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<script>
const inputImagen = document.getElementById('imagenArchivo');
const video = document.getElementById('videoCamara');
const canvas = document.getElementById('canvasFoto');
const preview = document.getElementById('previewFoto');
const previewImg = document.getElementById('fotoPreview');
const btnTomarFoto = document.getElementById('btnTomarFoto');
const btnCancelarFoto = document.getElementById('btnCancelarFoto');
const selectorCamara = document.getElementById('selectorCamara');
const selectorCamaraWrap = document.getElementById('selectorCamaraWrap');
let streamCamera = null;
let cameraDevices = [];

function mostrarPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImg.src = e.target.result;
        preview.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
}

async function detectarCamaras() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) return [];

    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        return devices.filter(device => device.kind === 'videoinput');
    } catch (error) {
        return [];
    }
}

function poblarSelectorCamaras() {
    selectorCamara.innerHTML = '';

    if (cameraDevices.length > 1) {
        selectorCamaraWrap.classList.remove('d-none');
        cameraDevices.forEach((device, index) => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.textContent = device.label || `Cámara ${index + 1}`;
            selectorCamara.appendChild(option);
        });
        if (!selectorCamara.value) {
            selectorCamara.value = cameraDevices[0].deviceId;
        }
    } else {
        selectorCamaraWrap.classList.add('d-none');
    }
}

async function abrirCamara(deviceId = null) {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        inputImagen.setAttribute('capture', 'environment');
        inputImagen.click();
        return;
    }

    try {
        const permisoInicial = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        permisoInicial.getTracks().forEach(track => track.stop());
    } catch (error) {
        // El navegador bloqueó el acceso; se cae al input de archivo como respaldo.
    }

    cameraDevices = await detectarCamaras();
    poblarSelectorCamaras();

    const selectedDeviceId = deviceId || selectorCamara.value || cameraDevices[0]?.deviceId;
    const constraints = selectedDeviceId
        ? {
            video: { deviceId: { exact: selectedDeviceId } },
            audio: false,
        }
        : {
            video: { facingMode: 'environment' },
            audio: false,
        };

    try {
        streamCamera = await navigator.mediaDevices.getUserMedia(constraints);
        video.srcObject = streamCamera;
        video.classList.remove('d-none');
        btnCancelarFoto.classList.remove('d-none');
        btnTomarFoto.textContent = 'Capturar foto';
    } catch (error) {
        try {
            streamCamera = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user' },
                audio: false,
            });
            video.srcObject = streamCamera;
            video.classList.remove('d-none');
            btnCancelarFoto.classList.remove('d-none');
            btnTomarFoto.textContent = 'Capturar foto';
        } catch (fallbackError) {
            inputImagen.setAttribute('capture', 'environment');
            inputImagen.click();
        }
    }
}

function cerrarCamara() {
    if (streamCamera) {
        streamCamera.getTracks().forEach(track => track.stop());
        streamCamera = null;
    }

    video.srcObject = null;
    video.classList.add('d-none');
    btnCancelarFoto.classList.add('d-none');
    btnTomarFoto.textContent = 'Tomar foto';
}

selectorCamara.addEventListener('change', async () => {
    if (streamCamera) {
        cerrarCamara();
    }
    await abrirCamara(selectorCamara.value);
});

btnTomarFoto.addEventListener('click', async () => {
    if (!streamCamera) {
        await abrirCamara();
        return;
    }

    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth || 1280;
    canvas.height = video.videoHeight || 720;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob((blob) => {
        if (!blob) return;

        const file = new File([blob], `articulo-${Date.now()}.png`, { type: 'image/png' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        inputImagen.files = dataTransfer.files;
        mostrarPreview(file);
        cerrarCamara();
    }, 'image/png');
});

btnCancelarFoto.addEventListener('click', () => {
    cerrarCamara();
});

inputImagen.addEventListener('change', () => {
    if (inputImagen.files && inputImagen.files[0]) {
        mostrarPreview(inputImagen.files[0]);
    }
});

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