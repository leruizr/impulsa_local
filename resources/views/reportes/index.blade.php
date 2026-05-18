{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="page-title mb-4">Reportes</h2>

<div class="row g-3">
    {{-- Tarjeta para el reporte de emprendedores activos --}}
    <div class="col-md-6">
        <div class="info-card h-100">
            <h5 class="info-card-title">
                <i class="bi bi-people-fill me-2"></i>Emprendedores Activos
            </h5>
            <p class="text-muted">
                Listado de todos los emprendedores con estado activo en el sistema,
                junto con sus datos de contacto y los programas en los que están inscritos.
            </p>
            <a href="{{ route('reportes.emprendedores-activos') }}" class="btn-marca-primary">Ver reporte</a>
        </div>
    </div>

    {{-- Tarjeta para el reporte de inscripciones por programa --}}
    <div class="col-md-6">
        <div class="info-card h-100">
            <h5 class="info-card-title">
                <i class="bi bi-clipboard-data-fill me-2"></i>Inscripciones por Programa
            </h5>
            <p class="text-muted">
                Detalle de cada programa de formación con la cantidad y nombres
                de los emprendedores inscritos, así como el cupo disponible.
            </p>
            <a href="{{ route('reportes.inscripciones') }}" class="btn-marca-primary">Ver reporte</a>
        </div>
    </div>
</div>
@endsection
