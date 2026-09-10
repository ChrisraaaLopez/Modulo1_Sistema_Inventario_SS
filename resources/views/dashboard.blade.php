@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-shell">
    <div class="page-header">
        <h1>Dashboard</h1>
        <div class="date-pill">Thursday, 10 de Septiembre de 2026</div>
    </div>

    <div class="panel-grid">
        <div class="metric-card primary">
            <div class="metric-body">
                <div class="metric-label">Total de artículos</div>
                <div class="metric-value">{{ $totales['articulos'] }}</div>
                <div class="metric-note">en el inventario</div>
            </div>
        </div>

        <div class="metric-card success">
            <div class="metric-body">
                <div class="metric-label">En buen estado</div>
                <div class="metric-value">{{ $totales['empleados'] }}</div>
                <div class="metric-note">estado "Bien"</div>
            </div>
        </div>

        <div class="metric-card danger">
            <div class="metric-body">
                <div class="metric-label">Dados / obsoletos</div>
                <div class="metric-value">0</div>
                <div class="metric-note">requieren atención</div>
            </div>
        </div>

        <div class="metric-card primary">
            <div class="metric-body">
                <div class="metric-label">Empleados activos</div>
                <div class="metric-value">{{ $totales['empleados'] }}</div>
                <div class="metric-note">con artículos asignables</div>
            </div>
        </div>
    </div>

    <div class="dashboard-row" style="grid-template-columns: 1fr;">
        <div class="mini-panel">
            <h3>Artículos por categoría</h3>
            <p class="muted-empty">Aún no hay artículos registrados.</p>
        </div>

        <div class="mini-panel">
            <h3>Periodo activo</h3>
            <p class="muted-empty">No hay un periodo de revisión abierto.</p>
            <div class="action-row">
                <button type="button" class="btn btn-primary">Crear periodo</button>
            </div>
        </div>
    </div>

    <div class="action-row" style="margin-top: 6px;">
        <button type="button" class="btn btn-primary">+ Nuevo artículo</button>
        <button type="button" class="btn btn-primary">+ Nuevo empleado</button>
        <button type="button" class="btn btn-secondary">Ir a escanear</button>
    </div>
</div>
@endsection