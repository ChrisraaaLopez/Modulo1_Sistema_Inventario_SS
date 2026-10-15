@extends('layouts.app')

@section('content')
    <div class="page">
        <div class="page-head">
            <div>
                <span class="eyebrow">REVISIÓN ACTIVA</span>
                <h1>{{ $resguardo->ubicacion->Nombre }}</h1>
                <p>{{ $resguardo->periodo->Nombre }} · Revisor: {{ $resguardo->revisor?->Nombre_Usuario ?? $resguardo->empleado->Nombre }} {{ $resguardo->empleado->Apellido_Paterno }}</p>
            </div>
            <a class="btn" href="{{ route('revision.close', $resguardo) }}">Ver cierre</a>
        </div>

        <div id="message" class="alert" style="display:none"></div>

        <div class="scan-grid">
            <div class="card scanner">
                <h2>Escanear artículo</h2>
                <div id="reader"></div>
                <p class="muted">Permite el acceso a la cámara. También puedes escribir el código o número de serie.</p>
                <form id="manualForm">
                    <div class="input-row">
                        <input id="codigo" placeholder="Código de barras / QR / serie">
                        <button class="btn primary">Buscar</button>
                    </div>
                </form>
                <div id="preview" class="scan-result" style="display:none"></div>
            </div>

            <div class="card">
                <div class="section-head">
                    <h2>Artículos esperados</h2>
                    <span id="counter" class="badge green">0 / {{ $items->count() }}</span>
                </div>
                <div class="expected-list">
                    @foreach ($items as $i)
                        <div id="item-{{ $i->FkId_Articulo }}" class="expected-item {{ $i->Revisado ? 'reviewed' : '' }}">
                            <div>
                                <strong>{{ $i->articulo->Descripcion }}</strong>
                                <small>{{ $i->articulo->Codigo_Barras ?: $i->articulo->N_Serie ?: 'Sin código' }}</small>
                            </div>
                            <span class="state">{{ $i->Revisado ? '✓ Revisado' : 'Pendiente' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        const lookupUrl = '{{ route('revision.scan.lookup', $resguardo) }}';
        const token = '{{ csrf_token() }}';
        let total = {{ $items->count() }};
        let reviewed = {{ $items->where('Revisado', true)->count() }};
        const msg = document.getElementById('message');

        function show(type, text) {
            msg.style.display = 'block';
            msg.className = 'alert ' + type;
            msg.textContent = text;
            clearTimeout(window.mt);
            window.mt = setTimeout(() => msg.style.display = 'none', 5000);
        }

        function update() {
            document.getElementById('counter').textContent = reviewed + ' / ' + total;
        }

        function render(a) {
            const p = document.getElementById('preview');
            p.style.display = 'block';
            p.replaceChildren();
            if (a.imagen) {
                const img = document.createElement('img');
                img.src = a.imagen;
                img.alt = 'Imagen de referencia de ' + (a.descripcion || 'artículo');
                img.className = 'model-img';
                img.loading = 'lazy';
                img.onerror = () => {
                    img.replaceWith(Object.assign(document.createElement('div'), {
                        className: 'model-img model-placeholder',
                        textContent: 'Imagen no disponible',
                    }));
                };
                p.appendChild(img);
            } else {
                const ph = document.createElement('div');
                ph.className = 'model-img model-placeholder';
                ph.textContent = a.modelo || 'MODELO';
                p.appendChild(ph);
            }

            const info = document.createElement('div');
            const title = document.createElement('strong');
            title.textContent = a.descripcion || 'Artículo';
            const model = document.createElement('div');
            model.textContent = (a.marca || '') + ' ' + (a.modelo || '');
            const small = document.createElement('small');
            small.textContent = 'Código: ' + (a.codigo || '—') + ' · Serie: ' + (a.serie || '—');
            info.append(title, model, small);
            p.appendChild(info);
        }

        function addExpectedItem(article) {
            const existing = document.getElementById('item-' + article.id);
            if (existing) {
                existing.classList.add('reviewed');
                existing.querySelector('.state').textContent = '✓ Revisado';
                return;
            }

            const list = document.querySelector('.expected-list');
            const item = document.createElement('div');
            item.id = 'item-' + article.id;
            item.className = 'expected-item reviewed';
            item.innerHTML = `
                <div>
                    <strong>${article.descripcion || 'Artículo'}</strong>
                    <small>${article.codigo || article.serie || 'Sin código'}</small>
                </div>
                <span class="state">✓ Revisado</span>
            `;
            list.appendChild(item);
            total += 1;
        }

        const scanner = window.Html5Qrcode;
        if (scanner) {
            const html5QrCode = new scanner('reader');
            html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 260, height: 260 } },
                async (decodedText) => {
                    lookup(decodedText);
                },
                () => {}
            ).catch(() => {
                show('warning', 'No se pudo iniciar la cámara del dispositivo. Puedes seguir usando el ingreso manual.');
            });
        } else {
            show('warning', 'El escáner local no está disponible. Puedes continuar con búsqueda manual.');
        }

        async function lookup(code) {
            if (! code) {
                return;
            }

            try {
                const r = await fetch(lookupUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ codigo: code }),
                });

                const d = await r.json();
                if (d.article) {
                    render(d.article);
                }

                if (d.type === 'reviewed') {
                    reviewed += 1;
                    const el = document.getElementById('item-' + d.article.id);
                    if (el) {
                        el.classList.add('reviewed');
                        el.querySelector('.state').textContent = '✓ Revisado';
                    }
                    show('ok', 'Artículo revisado correctamente.');
                    update();
                } else if (d.type === 'already_reviewed') {
                    show('warning', d.message);
                } else if (d.type === 'wrong_location') {
                    show('warning', d.message + ' Ubicación registrada: ' + d.actual_location + '.');
                    const ok = confirm('El artículo está en otra ubicación. ¿Quieres reasignarlo a ' + d.expected_location + ' y marcarlo como revisado?');
                    if (ok) {
                        const rr = await fetch('{{ url('/revision/resguardos') }}/{{ $resguardo->Id_Resguardo }}/reasignar/' + d.article.id, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ confirmacion: true }),
                        });
                        const rd = await rr.json();
                        if (rd.ok) {
                            reviewed += 1;
                            addExpectedItem(d.article);
                            show('ok', rd.message);
                            update();
                        } else if (rd.type === 'blocked') {
                            show('danger', rd.message);
                        } else {
                            show('danger', rd.message || 'No se pudo reasignar el artículo.');
                        }
                    }
                } else if (d.type === 'not_expected') {
                    show('warning', d.message);
                } else if (d.type === 'not_found') {
                    show('danger', d.message);
                } else if (! r.ok) {
                    show('danger', d.message || 'Error al consultar');
                }
            } catch (e) {
                show('danger', 'No fue posible consultar el artículo.');
            }
        }

        document.getElementById('manualForm').addEventListener('submit', (e) => {
            e.preventDefault();
            lookup(document.getElementById('codigo').value.trim());
            document.getElementById('codigo').value = '';
        });

        update();
    </script>
@endsection
