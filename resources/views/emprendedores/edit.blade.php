{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="mb-3">Editar Emprendedor</h2>

{{-- Formulario que envía los datos al método update() del EmprendedorController --}}
{{-- La ruta incluye el ID del emprendedor para identificar cuál se actualiza --}}
<form action="{{ route('emprendedores.update', $emprendedor->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- Simula el método HTTP PUT, ya que los formularios HTML solo soportan GET y POST --}}

    {{-- Campo: Nombre completo (pre-cargado con el valor actual del emprendedor) --}}
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        {{-- old() toma prioridad si hubo un error de validación; si no, usa el valor actual de BD --}}
        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $emprendedor->nombre) }}" required>
        @error('nombre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo: Tipo de actividad económica (marca como seleccionada la opción actual) --}}
    <div class="mb-3">
        <label for="actividad_economica" class="form-label">Actividad Económica</label>
        <select class="form-select @error('actividad_economica') is-invalid @enderror" id="actividad_economica" name="actividad_economica" required>
            <option value="">Seleccione...</option>
            <option value="artesano" {{ old('actividad_economica', $emprendedor->actividad_economica) == 'artesano' ? 'selected' : '' }}>Artesano</option>
            <option value="panadería" {{ old('actividad_economica', $emprendedor->actividad_economica) == 'panadería' ? 'selected' : '' }}>Panadería</option>
            <option value="taller" {{ old('actividad_economica', $emprendedor->actividad_economica) == 'taller' ? 'selected' : '' }}>Taller</option>
            <option value="tienda" {{ old('actividad_economica', $emprendedor->actividad_economica) == 'tienda' ? 'selected' : '' }}>Tienda</option>
            <option value="otro" {{ old('actividad_economica', $emprendedor->actividad_economica) == 'otro' ? 'selected' : '' }}>Otro</option>
        </select>
        @error('actividad_economica')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo: Dirección o barrio del negocio (pre-cargado) --}}
    <div class="mb-3">
        <label for="ubicacion" class="form-label">Ubicación</label>
        <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $emprendedor->ubicacion) }}" required>
        @error('ubicacion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo: Teléfono de contacto (pre-cargado) --}}
    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $emprendedor->telefono) }}" required>
        @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo: Correo electrónico (pre-cargado) --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $emprendedor->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Campo: Estado del emprendedor (marca la opción actual como seleccionada) --}}
    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
            <option value="activo" {{ old('estado', $emprendedor->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado', $emprendedor->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Botones: Cancelar regresa al listado, Actualizar envía el formulario --}}
    <a href="{{ route('emprendedores.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection
