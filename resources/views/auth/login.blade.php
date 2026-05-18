{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
<h2 class="page-title mb-4 text-center">Iniciar Sesión</h2>

{{-- Tarjeta contenedora del formulario, centrada y con ancho máximo --}}
<div class="form-card mx-auto" style="max-width: 480px;">
    {{-- Selector de rol mediante pestañas: Emprendedor / Administrador --}}
    <ul class="nav nav-pills nav-fill mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $rolSeleccionado === 'emprendedor' ? 'active' : '' }}"
               href="{{ route('login', ['rol' => 'emprendedor']) }}">Emprendedor</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $rolSeleccionado === 'admin' ? 'active' : '' }}"
               href="{{ route('login', ['rol' => 'admin']) }}">Administrador</a>
        </li>
    </ul>

    {{-- Formulario que envía las credenciales al método login() del AuthController --}}
    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf

        {{-- Campo oculto que viaja con el rol seleccionado por el usuario --}}
        <input type="hidden" name="rol" value="{{ $rolSeleccionado }}">

        {{-- Campo: correo electrónico --}}
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                   id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo: contraseña --}}
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                   id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Recordarme --}}
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn-marca-primary btn-marca-lg">Ingresar</button>
        </div>
    </form>

    {{-- Solo el rol emprendedor permite auto-registro desde la web --}}
    @if($rolSeleccionado === 'emprendedor')
        <div class="text-center">
            <span class="text-muted">¿Aún no tiene cuenta?</span>
            <a href="{{ route('register') }}" class="text-decoration-none ms-1">Registrarse como emprendedor</a>
        </div>
    @endif
</div>
@endsection
