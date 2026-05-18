{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con título y botones de acción --}}
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h2 class="page-title">Reporte: Inscripciones por Programa</h2>
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
    <p class="text-muted m-0">Reporte de Inscripciones por Programa de Formación</p>
    <p class="text-muted m-0">Generado el: {{ now()->format('d/m/Y H:i') }}</p>
</div>

{{-- Tarjeta con el total general --}}
<div class="info-card mb-4">
    <h5 class="info-card-title m-0">
        Total de programas: <span class="badge-info-marca ms-2">{{ $programas->count() }}</span>
        <span class="ms-3">Total de inscripciones registradas:</span>
        <span class="badge-activo ms-2">{{ $totalInscripciones }}</span>
    </h5>
</div>

@if($programas->isEmpty())
    <div class="alert alert-info text-center">No hay programas de formación registrados.</div>
@else
    {{-- Por cada programa, se muestra una tarjeta con su tabla de inscritos --}}
    @foreach($programas as $programa)
        @php
            $inscritos = $programa->emprendedores->count();
        @endphp
        <div class="info-card mb-4 reporte-bloque">
            <h5 class="info-card-title d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span>{{ $programa->nombre }}</span>
                <span>
                    @if($programa->estado === 'activo')
                        <span class="badge-activo">Activo</span>
                    @else
                        <span class="badge-inactivo">Inactivo</span>
                    @endif
                    <span class="badge-info-marca ms-2">{{ $inscritos }} / {{ $programa->cupo_maximo }}</span>
                </span>
            </h5>
            <p class="text-muted">{{ $programa->descripcion }}</p>

            @if($programa->emprendedores->isEmpty())
                <div class="alert alert-info mb-0">No hay emprendedores inscritos en este programa.</div>
            @else
                <div class="tabla-wrapper">
                    <div class="table-responsive">
                        <table class="tabla-marca">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Emprendedor</th>
                                    <th>Actividad</th>
                                    <th>Ubicación</th>
                                    <th>Teléfono</th>
                                    <th>Fecha de Inscripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($programa->emprendedores as $i => $emprendedor)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $emprendedor->nombre }}</td>
                                    <td>{{ ucfirst($emprendedor->actividad_economica) }}</td>
                                    <td>{{ $emprendedor->ubicacion }}</td>
                                    <td>{{ $emprendedor->telefono }}</td>
                                    <td>{{ $emprendedor->pivot->fecha_inscripcion }}</td>
                                    <td>
                                        @if($emprendedor->pivot->estado === 'en_curso')
                                            <span class="badge-info-marca">En curso</span>
                                        @elseif($emprendedor->pivot->estado === 'completado')
                                            <span class="badge-activo">Completado</span>
                                        @else
                                            <span class="badge-inactivo">Cancelado</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
@endif
@endsection
