{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para volver al listado --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Detalle del Emprendedor</h2>
    <a href="{{ route('emprendedores.index') }}" class="btn-marca-secondary">Volver al listado</a>
</div>

{{-- Tarjeta con los datos del emprendedor --}}
<div class="info-card mb-4">
    <h5 class="info-card-title">{{ $emprendedor->nombre }}</h5>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Actividad Económica:</strong> {{ ucfirst($emprendedor->actividad_economica) }}</p>
            <p><strong>Ubicación:</strong> {{ $emprendedor->ubicacion }}</p>
            <p class="mb-0"><strong>Teléfono:</strong> {{ $emprendedor->telefono }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Email:</strong> {{ $emprendedor->email }}</p>
            <p class="mb-0">
                <strong>Estado:</strong>
                @if($emprendedor->estado === 'activo')
                    <span class="badge-activo">Activo</span>
                @else
                    <span class="badge-inactivo">Inactivo</span>
                @endif
            </p>
        </div>
    </div>
</div>

{{-- Tarjeta con los programas en los que el emprendedor está inscrito --}}
<div class="info-card mb-4">
    <h5 class="info-card-title">Programas Inscritos</h5>

    @if($emprendedor->programasFormacion->isEmpty())
        <div class="alert alert-info mb-0">El emprendedor no está inscrito en ningún programa.</div>
    @else
        <div class="tabla-wrapper">
            <div class="table-responsive">
                <table class="tabla-marca">
                    <thead>
                        <tr>
                            <th>Programa</th>
                            <th>Descripción</th>
                            <th>Fecha de Inscripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Itera sobre cada programa inscrito y muestra una fila en la tabla --}}
                        @foreach($emprendedor->programasFormacion as $programa)
                        <tr>
                            <td>{{ $programa->nombre }}</td>
                            <td>{{ $programa->descripcion }}</td>
                            <td>{{ $programa->pivot->fecha_inscripcion }}</td>
                            <td>
                                {{-- Muestra un badge de color distinto según el estado de la inscripción --}}
                                @if($programa->pivot->estado === 'en_curso')
                                    <span class="badge-info-marca">En curso</span>
                                @elseif($programa->pivot->estado === 'completado')
                                    <span class="badge-activo">Completado</span>
                                @else
                                    <span class="badge-inactivo">Cancelado</span>
                                @endif
                            </td>
                            <td>
                                {{-- Formulario de cancelación: usa método DELETE con confirmación previa --}}
                                <form action="{{ route('inscripciones.destroy', [$emprendedor->id, $programa->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-marca-danger btn-marca-sm" onclick="return confirm('¿Está seguro de cancelar esta inscripción?')">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- Tarjeta con los programas disponibles para inscripción --}}
<div class="info-card">
    <h5 class="info-card-title">Programas Disponibles</h5>

    {{-- Mensaje de error de validación si la inscripción fue rechazada (ej: programa duplicado) --}}
    @error('programa_formacion_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @if($programasDisponibles->isEmpty())
        {{-- No hay programas activos disponibles para inscripción --}}
        <div class="alert alert-warning mb-0">No hay programas activos disponibles para inscripción.</div>
    @else
        <div class="tabla-wrapper">
            <div class="table-responsive">
                <table class="tabla-marca">
                    <thead>
                        <tr>
                            <th>Programa</th>
                            <th>Descripción</th>
                            <th>Disponibilidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Itera sobre cada programa activo no inscrito y muestra una fila --}}
                        @foreach($programasDisponibles as $programa)
                            @php
                                // Cuenta cuántos emprendedores están actualmente inscritos en este programa
                                $inscritos = $programa->emprendedores->count();
                                $cupo     = $programa->cupo_maximo;
                                $hayCupo  = $inscritos < $cupo;
                            @endphp
                            <tr>
                                <td>{{ $programa->nombre }}</td>
                                <td>{{ $programa->descripcion }}</td>
                                <td>{{ $inscritos }}/{{ $cupo }}</td>
                                <td>
                                    @if($hayCupo)
                                        {{-- Si hay cupo, muestra el botón de inscripción --}}
                                        <form action="{{ route('inscripciones.store', $emprendedor->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="programa_formacion_id" value="{{ $programa->id }}">
                                            <button type="submit" class="btn-marca-primary btn-marca-sm">Inscribirse</button>
                                        </form>
                                    @else
                                        {{-- Si no hay cupo, muestra un botón gris deshabilitado --}}
                                        <button class="btn-marca-secondary btn-marca-sm" disabled>Sin cupo</button>
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
