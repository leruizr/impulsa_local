{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para volver al listado --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Detalle del Emprendedor</h2>
    <a href="{{ route('emprendedores.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>

{{-- Tarjeta con los datos del emprendedor --}}
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">{{ $emprendedor->nombre }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Actividad Económica:</strong> {{ ucfirst($emprendedor->actividad_economica) }}</p>
                <p><strong>Ubicación:</strong> {{ $emprendedor->ubicacion }}</p>
                <p><strong>Teléfono:</strong> {{ $emprendedor->telefono }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Email:</strong> {{ $emprendedor->email }}</p>
                <p>
                    <strong>Estado:</strong>
                    @if($emprendedor->estado === 'activo')
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Tabla con los programas en los que el emprendedor está inscrito --}}
<h4 class="mb-3">Programas Inscritos</h4>
<div class="table-responsive mb-4">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
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
                        <span class="badge bg-info text-dark">En curso</span>
                    @elseif($programa->pivot->estado === 'completado')
                        <span class="badge bg-success">Completado</span>
                    @else
                        <span class="badge bg-secondary">Cancelado</span>
                    @endif
                </td>
                <td>
                    {{-- Formulario de cancelación: usa método DELETE con confirmación previa --}}
                    <form action="{{ route('inscripciones.destroy', [$emprendedor->id, $programa->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de cancelar esta inscripción?')">Cancelar inscripción</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mensaje informativo cuando el emprendedor no está inscrito en ningún programa --}}
@if($emprendedor->programasFormacion->isEmpty())
    <div class="alert alert-info text-center mb-4">El emprendedor no está inscrito en ningún programa.</div>
@endif

{{-- Tarjeta con el formulario para inscribir al emprendedor en un nuevo programa --}}
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Inscribir en un nuevo programa</h5>
    </div>
    <div class="card-body">
        @if($programasDisponibles->isEmpty())
            {{-- No hay programas activos disponibles para inscripción --}}
            <div class="alert alert-warning mb-0">No hay programas activos disponibles para inscripción.</div>
        @else
            {{-- Formulario que envía los datos al método store() del InscripcionController --}}
            <form action="{{ route('inscripciones.store', $emprendedor->id) }}" method="POST">
                @csrf

                {{-- Campo: Programa de formación a inscribir (solo programas activos no inscritos) --}}
                <div class="mb-3">
                    <label for="programa_formacion_id" class="form-label">Programa de Formación</label>
                    <select class="form-select @error('programa_formacion_id') is-invalid @enderror" id="programa_formacion_id" name="programa_formacion_id" required>
                        <option value="">Seleccione un programa...</option>
                        @foreach($programasDisponibles as $programa)
                            <option value="{{ $programa->id }}" {{ old('programa_formacion_id') == $programa->id ? 'selected' : '' }}>
                                {{ $programa->nombre }} (Cupo: {{ $programa->cupo_maximo }})
                            </option>
                        @endforeach
                    </select>
                    @error('programa_formacion_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Inscribir</button>
            </form>
        @endif
    </div>
</div>
@endsection
