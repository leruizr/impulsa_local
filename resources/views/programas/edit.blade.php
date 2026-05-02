{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="page-title mb-4">Editar Programa de Formación</h2>

{{-- Tarjeta contenedora del formulario --}}
<div class="form-card">
    {{-- Formulario que envía los datos al método update() del ProgramaFormacionController --}}
    {{-- La ruta incluye el ID del programa para identificar cuál se actualiza --}}
    <form action="{{ route('programas.update', $programa->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Simula el método HTTP PUT, ya que los formularios HTML solo soportan GET y POST --}}

        {{-- Campo: Nombre del programa (pre-cargado con el valor actual) --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            {{-- old() toma prioridad si hubo un error de validación; si no, usa el valor actual de BD --}}
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $programa->nombre) }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Descripción detallada del programa (pre-cargada) --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $programa->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Cupo máximo de emprendedores (pre-cargado) --}}
        <div class="mb-3">
            <label for="cupo_maximo" class="form-label">Cupo Máximo</label>
            <input type="number" min="1" class="form-control @error('cupo_maximo') is-invalid @enderror" id="cupo_maximo" name="cupo_maximo" value="{{ old('cupo_maximo', $programa->cupo_maximo) }}" required>
            @error('cupo_maximo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Estado del programa (marca la opción actual como seleccionada) --}}
        <div class="mb-4">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                <option value="activo" {{ old('estado', $programa->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado', $programa->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones: Cancelar regresa al listado, Actualizar envía el formulario --}}
        <div class="d-flex gap-2">
            <a href="{{ route('programas.index') }}" class="btn-marca-secondary">Cancelar</a>
            <button type="submit" class="btn-marca-primary">Actualizar</button>
        </div>
    </form>
</div>
@endsection
