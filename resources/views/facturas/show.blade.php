@extends('layouts.app')

@section('title', 'Ver factura')

@section('content')
<h1>Factura {{ $factura->Folio }}</h1>

<p>
    <strong>Proveedor:</strong> {{ $factura->Proveedor }} &nbsp;|&nbsp;
    <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($factura->Fecha)->format('d/m/Y') }} &nbsp;|&nbsp;
    <strong>Monto:</strong> ${{ number_format($factura->Monto, 2) }}
</p>

@if($factura->URL_Factura)
    <embed src="{{ Storage::url($factura->URL_Factura) }}" type="application/pdf" width="100%" height="700px">
@else
    <p class="text-muted">Esta factura no tiene PDF cargado todavía.</p>
@endif

<a href="{{ route('facturas.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection