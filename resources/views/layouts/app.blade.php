<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Inventario')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
        }
        .sidebar {
            min-height: 100vh;
            width: 230px;
            background-color: #1F3864;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 10px 20px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .sidebar .nav-header {
            color: rgba(255,255,255,.5);
            font-size: .75rem;
            text-transform: uppercase;
            padding: 16px 20px 6px;
        }
        .sidebar .brand {
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 18px 20px;
            display: block;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }
        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
        .wrapper {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <a href="{{ url('/') }}" class="brand">📦 Sistema de Inventario</a>

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