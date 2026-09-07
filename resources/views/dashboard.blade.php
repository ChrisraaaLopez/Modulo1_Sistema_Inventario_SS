@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1>Panel de control</h1>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h5 class="card-title">Artículos</h5>
                <p class="card-text fs-2">{{ $totales['articulos'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">Empleados</h5>
                <p class="card-text fs-2">{{ $totales['empleados'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h5 class="card-title">Marcas</h5>
                <p class="card-text fs-2">{{ $totales['marcas'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-secondary">
            <div class="card-body">
                <h5 class="card-title">Facturas</h5>
                <p class="card-text fs-2">{{ $totales['facturas'] }}</p>
            </div>
        </div>
    </div>
</div>
@endsection