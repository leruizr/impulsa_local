{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="mb-3">Crear Nuevo Programa de Formación</h2>

{{-- Formulario que envía los datos al método store() del ProgramaFormacionController --}}
<form action="{{ route('programas.store') }}" method="POST">
    @csrf {{-- Token de seguridad para proteger contra ataques CSRF --}}

    {{-- Campo: Nombre del programa (ej: Marketing Digital) --}}
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        {{-- Si hay error de validación, agrega la clase 'is-invalid' para resaltar el campo --}}
        {{-- old() recupera el valor anterior si el formulario fue rechazado por validación --}}
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo: Descripción detallada del programa (área de texto) --}}
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
        @error('descripcion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Botones: Cancelar regresa al listado, Guardar envía el formulario --}}
    <a href="{{ route('programas.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection
