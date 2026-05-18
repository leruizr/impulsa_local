{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para volver al listado --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Detalle del Programa</h2>
    <a href="{{ route('programas.index') }}" class="btn-marca-secondary">Volver al listado</a>
</div>

{{-- Tarjeta con los datos del programa --}}
<div class="info-card mb-4">
    <h5 class="info-card-title">{{ $programa->nombre }}</h5>
    <div class="row">
        <div class="col-md-8">
            <p><strong>Descripción:</strong> {{ $programa->descripcion }}</p>
        </div>
        <div class="col-md-4">
            <p><strong>Cupo máximo:</strong> {{ $programa->cupo_maximo }}</p>
            <p>
                <strong>Inscritos:</strong> {{ $totalInscritos }} / {{ $programa->cupo_maximo }}
            </p>
            <p class="mb-0">
                <strong>Estado:</strong>
                @if($programa->estado === 'activo')
                    <span class="badge-activo">Activo</span>
                @else
                    <span class="badge-inactivo">Inactivo</span>
                @endif
            </p>
        </div>
    </div>
</div>

{{-- Tarjeta con los emprendedores inscritos al programa --}}
<div class="info-card">
    <h5 class="info-card-title">Emprendedores Inscritos</h5>

    @if($programa->emprendedores->isEmpty())
        <div class="alert alert-info mb-0">Aún no hay emprendedores inscritos en este programa.</div>
    @else
        <div class="tabla-wrapper">
            <div class="table-responsive">
                <table class="tabla-marca">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Actividad Económica</th>
                            <th>Ubicación</th>
                            <th>Teléfono</th>
                            <th>Fecha de Inscripción</th>
                            <th>Estado de la Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Itera sobre cada emprendedor inscrito y muestra una fila --}}
                        @foreach($programa->emprendedores as $emprendedor)
                        <tr>
                            <td>{{ $emprendedor->nombre }}</td>
                            <td>{{ ucfirst($emprendedor->actividad_economica) }}</td>
                            <td>{{ $emprendedor->ubicacion }}</td>
                            <td>{{ $emprendedor->telefono }}</td>
                            <td>{{ $emprendedor->pivot->fecha_inscripcion }}</td>
                            <td>
                                {{-- Muestra un badge de color distinto según el estado de la inscripción --}}
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
@endsection
