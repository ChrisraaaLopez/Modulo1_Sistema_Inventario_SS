<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Inventario')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy-900: #1f2d4d;
            --navy-800: #243a5c;
            --navy-700: #2b4f82;
            --blue-600: #2f71e8;
            --blue-500: #2d6de5;
            --bg-soft: #f3f5f8;
            --panel: #f7f8fb;
            --panel-strong: #ffffff;
            --line: rgba(24, 35, 54, 0.08);
            --text: #1b2433;
            --muted: #64748b;
            --shadow-soft: 0 8px 18px rgba(24, 35, 54, 0.06);
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-soft);
            color: var(--text);
        }

        .sidebar {
            min-height: 100vh;
            width: 230px;
            background: linear-gradient(180deg, #1d2c4c 0%, #182843 100%);
            box-shadow: inset -1px 0 0 rgba(255,255,255,.06);
            display: flex;
            flex-direction: column;
        }

        .sidebar .nav {
            padding-top: 10px;
            gap: 2px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.82);
            padding: 12px 18px;
            margin: 2px 10px;
            border-radius: 10px;
            font-size: .97rem;
            font-weight: 500;
            transition: all .2s ease;
            letter-spacing: .01em;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(74, 118, 218, 0.9), rgba(52, 96, 210, 0.88));
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.08), 0 6px 14px rgba(7, 18, 36, 0.12);
        }

        .sidebar .nav-header {
            color: rgba(255,255,255,.52);
            font-size: .75rem;
            text-transform: uppercase;
            padding: 18px 20px 8px;
            letter-spacing: .06em;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
            padding: 18px 18px 18px;
            border-bottom: 1px solid rgba(255,255,255,.12);
            min-height: 78px;
            background: rgba(255,255,255,.02);
        }

        .sidebar .brand:hover {
            color: #fff;
            text-decoration: none;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(145deg, #f4f7ff 0%, #dfeaff 100%);
            box-shadow: inset 0 0 0 1px rgba(17,41,85,.12), 0 6px 14px rgba(13,24,42,.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 800;
            color: #1f2f4d;
            font-size: .8rem;
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-copy strong {
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .brand-copy small {
            color: rgba(255,255,255,.74);
            font-size: .68rem;
            margin-top: 3px;
            letter-spacing: .02em;
        }

        .main-content {
            flex: 1;
            padding: 30px 30px 40px;
            background: var(--bg-soft);
        }

        .wrapper {
            display: flex;
        }

        .page-shell {
            background: transparent;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .page-header h1,
        .page-header h2 {
            margin: 0;
            font-size: 2.1rem;
            font-weight: 700;
            color: #1c2a3a;
        }

        .page-header .date-pill {
            color: #5f6f85;
            font-size: 1rem;
            font-weight: 500;
        }

        .card-panel {
            background: rgba(255,255,255,.76);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow-soft);
            padding: 18px 20px;
        }

        .panel-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 26px;
        }

        .metric-card {
            background: rgba(255,255,255,0.76);
            border: 1px solid var(--line);
            border-radius: 18px;
            min-height: 134px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-soft);
        }

        .metric-card .metric-body {
            text-align: center;
            width: 100%;
        }

        .metric-card .metric-label {
            color: #4d5f7a;
            font-size: .82rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .metric-card .metric-value {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
            color: #0f172a;
        }

        .metric-card .metric-note {
            color: #64748b;
            font-size: .98rem;
            margin-top: 8px;
        }

        .metric-card.success .metric-value { color: #1ca46d; }
        .metric-card.danger .metric-value { color: #e13f3a; }
        .metric-card.primary .metric-value { color: #1669d5; }

        .dashboard-row {
            display: grid;
            grid-template-columns: 1.9fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .mini-panel {
            background: rgba(255,255,255,0.76);
            border: 1px solid var(--line);
            border-radius: 18px;
            min-height: 180px;
            box-shadow: var(--shadow-soft);
            padding: 20px 22px;
        }

        .mini-panel h3 {
            margin: 0 0 18px;
            font-size: 1.08rem;
            font-weight: 700;
            color: #1a2436;
        }

        .muted-empty {
            color: #5d6d83;
            font-size: 1rem;
            margin: 0;
        }

        .btn-primary {
            background: linear-gradient(180deg, #2d6de5, #1f63d3);
            border: none;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 16px rgba(41, 104, 214, 0.16);
        }

        .btn-primary:hover {
            background: linear-gradient(180deg, #2866d6, #1c5fb9);
        }

        .btn-secondary {
            background: #eaf1ff;
            color: #244c91;
            border: none;
            border-radius: 10px;
            font-weight: 700;
        }

        .btn-warning,
        .btn-danger,
        .btn-info,
        .btn-success {
            border-radius: 8px;
            font-weight: 600;
        }

        .table {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-soft);
        }

        .table thead th {
            background: #f4f7fc;
            color: #37475f;
            font-weight: 700;
            text-transform: none;
            border-bottom: 1px solid var(--line);
        }

        .table td,
        .table th {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-color: var(--line);
        }

        .form-control,
        .form-select {
            border: 1px solid #dfe5ef;
            background: #fff;
            border-radius: 10px;
            box-shadow: none;
            min-height: 42px;
            color: var(--text);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(47, 113, 232, 0.6);
            box-shadow: 0 0 0 0.2rem rgba(47, 113, 232, 0.12);
        }

        .form-label {
            font-weight: 600;
            color: #42546d;
            margin-bottom: 0.45rem;
        }

        .action-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .toolbar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .toolbar .btn {
            min-height: 42px;
        }

        .filter-group {
            display: grid;
            grid-template-columns: repeat(5, minmax(140px, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .card-form {
            background: rgba(255,255,255,0.8);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow-soft);
            padding: 22px;
        }

        @media (max-width: 1100px) {
            .panel-grid,
            .dashboard-row,
            .filter-group {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .wrapper {
                display: block;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .main-content {
                padding: 20px 16px 28px;
            }

            .panel-grid,
            .dashboard-row,
            .filter-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <a href="{{ url('/') }}" class="brand" aria-label="Inventario TSJ">
                <span class="brand-mark" aria-hidden="true"></span>
                <span class="brand-copy">
                    <strong>Inventario TSJ</strong>
                    <small>Control Patrimonial</small>
                </span>
            </a>

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Dashboard</a>
                </li>

                @if(Route::has('articulos.index'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('articulos.*') ? 'active' : '' }}" href="{{ route('articulos.index') }}">Artículos</a>
                </li>
                @endif

                @if(Route::has('empleados.index'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleados.*') ? 'active' : '' }}" href="{{ route('empleados.index') }}">Empleados</a>
                </li>
                @endif

                @if(Route::has('facturas.index'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('facturas.*') ? 'active' : '' }}" href="{{ route('facturas.index') }}">Facturas</a>
                </li>
                @endif

                <li class="nav-header">Catálogos</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('marcas.*') ? 'active' : '' }}" href="{{ route('marcas.index') }}">Marcas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tipos.*') ? 'active' : '' }}" href="{{ route('tipos.index') }}">Tipos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ubicaciones.*') ? 'active' : '' }}" href="{{ route('ubicaciones.index') }}">Ubicaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('puestos.*') ? 'active' : '' }}" href="{{ route('puestos.index') }}">Puestos</a>
                </li>

                @if(Route::has('modelos.index'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modelos.*') ? 'active' : '' }}" href="{{ route('modelos.index') }}">Modelos</a>
                </li>
                @endif
            </ul>
        </nav>

        <div class="main-content">
            @if(session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>