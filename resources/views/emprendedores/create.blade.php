{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="page-title mb-4">Registrar Nuevo Emprendedor</h2>

{{-- Tarjeta contenedora del formulario --}}
<div class="form-card">
    {{-- Formulario que envía los datos al método store() del EmprendedorController --}}
    <form action="{{ route('emprendedores.store') }}" method="POST">
        @csrf {{-- Token de seguridad para proteger contra ataques CSRF --}}

        {{-- Campo: Nombre completo del emprendedor --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            {{-- Si hay error de validación, agrega la clase 'is-invalid' para resaltar el campo --}}
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Tipo de actividad económica (lista de opciones fijas) --}}
        <div class="mb-3">
            <label for="actividad_economica" class="form-label">Actividad Económica</label>
            <select class="form-select @error('actividad_economica') is-invalid @enderror" id="actividad_economica" name="actividad_economica" required>
                <option value="">Seleccione...</option>
                {{-- old() recupera el valor anterior si el formulario fue rechazado por validación --}}
                <option value="artesano" {{ old('actividad_economica') == 'artesano' ? 'selected' : '' }}>Artesano</option>
                <option value="panadería" {{ old('actividad_economica') == 'panadería' ? 'selected' : '' }}>Panadería</option>
                <option value="taller" {{ old('actividad_economica') == 'taller' ? 'selected' : '' }}>Taller</option>
                <option value="tienda" {{ old('actividad_economica') == 'tienda' ? 'selected' : '' }}>Tienda</option>
                <option value="otro" {{ old('actividad_economica') == 'otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('actividad_economica')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Dirección o barrio del negocio --}}
        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación</label>
            <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" required>
            @error('ubicacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Número de teléfono de contacto --}}
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Correo electrónico del emprendedor --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: Estado del emprendedor (activo o inactivo) --}}
        <div class="mb-4">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones: Cancelar regresa al listado, Guardar envía el formulario --}}
        <div class="d-flex gap-2">
            <a href="{{ route('emprendedores.index') }}" class="btn-marca-secondary">Cancelar</a>
            <button type="submit" class="btn-marca-primary">Guardar</button>
        </div>
    </form>
</div>
@endsection
