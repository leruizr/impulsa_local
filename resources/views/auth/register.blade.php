{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="page-title mb-4 text-center">Registro de Emprendedor</h2>

{{-- Tarjeta contenedora del formulario, centrada y con ancho máximo --}}
<div class="form-card mx-auto" style="max-width: 640px;">
    {{-- Formulario que envía los datos al método register() del AuthController --}}
    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- Campo: nombre completo --}}
            <div class="col-md-6 mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                       id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo: actividad económica --}}
            <div class="col-md-6 mb-3">
                <label for="actividad_economica" class="form-label">Actividad Económica</label>
                <select class="form-select @error('actividad_economica') is-invalid @enderror"
                        id="actividad_economica" name="actividad_economica" required>
                    <option value="">Seleccione...</option>
                    <option value="artesano"  {{ old('actividad_economica') == 'artesano' ? 'selected' : '' }}>Artesano</option>
                    <option value="panadería" {{ old('actividad_economica') == 'panadería' ? 'selected' : '' }}>Panadería</option>
                    <option value="taller"    {{ old('actividad_economica') == 'taller' ? 'selected' : '' }}>Taller</option>
                    <option value="tienda"    {{ old('actividad_economica') == 'tienda' ? 'selected' : '' }}>Tienda</option>
                    <option value="otro"      {{ old('actividad_economica') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('actividad_economica')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Campo: ubicación del negocio --}}
        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación</label>
            <input type="text" class="form-control @error('ubicacion') is-invalid @enderror"
                   id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" required>
            @error('ubicacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            {{-- Campo: teléfono --}}
            <div class="col-md-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                       id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo: correo electrónico (también se usa como usuario para iniciar sesión) --}}
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row">
            {{-- Campo: contraseña --}}
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password" required>
                <small class="text-muted">Mínimo 8 caracteres.</small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Campo: confirmación de contraseña --}}
            <div class="col-md-6 mb-4">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control"
                       id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('login') }}" class="btn-marca-secondary">Cancelar</a>
            <button type="submit" class="btn-marca-primary">Crear cuenta</button>
        </div>
    </form>
</div>
@endsection
