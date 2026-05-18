{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con título, fecha y botones de acción --}}
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2 class="page-title">Reporte: Emprendedores Activos</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('reportes.index') }}" class="btn-marca-secondary">Volver</a>
        <button type="button" class="btn-marca-primary" onclick="window.print()">
            <i class="bi bi-printer-fill me-1"></i>Imprimir / PDF
        </button>
    </div>
</div>

{{-- Bloque visible al imprimir con encabezado institucional --}}
<div class="reporte-encabezado mb-3">
    <h3 class="m-0">Impulsa Local - Alcaldía de Ciudad Nueva</h3>
    <p class="text-muted m-0">Reporte de Emprendedores Activos</p>
    <p class="text-muted m-0">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
</div>

{{-- Tarjeta con el total general --}}
<div class="info-card mb-4">
    <h5 class="info-card-title m-0">
        Total de emprendedores activos:
        <span class="badge-activo ms-2">{{ $total }}</span>
    </h5>
</div>

{{-- Tabla con el listado --}}
<div class="tabla-wrapper">
    <div class="table-responsive">
        <table class="tabla-marca">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Actividad</th>
                    <th>Ubicación</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Programas inscritos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emprendedores as $i => $emprendedor)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $emprendedor->nombre }}</td>
                    <td>{{ ucfirst($emprendedor->actividad_economica) }}</td>
                    <td>{{ $emprendedor->ubicacion }}</td>
                    <td>{{ $emprendedor->telefono }}</td>
                    <td>{{ $emprendedor->email }}</td>
                    <td>{{ $emprendedor->programasFormacion->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($emprendedores->isEmpty())
    <div class="alert alert-info text-center mt-3">No hay emprendedores activos en el sistema.</div>
@endif
@endsection
