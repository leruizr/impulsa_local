{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Hero de bienvenida con título grande, descripción y dos botones de acceso rápido --}}
<div class="hero-marca">
    <h1>Bienvenido a Impulsa Local</h1>
    <p class="lead">
        Programa de la Alcaldía de Ciudad Nueva para la digitalización y gestión
        de emprendedores locales: artesanos, panaderías, talleres y tiendas de barrio.
        Permite registrar emprendedores, gestionar su información e inscribirlos en
        programas de formación que fortalezcan sus negocios.
    </p>

    @auth
        {{-- Si el usuario ya tiene sesión, ofrece accesos rápidos según su rol --}}
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            @if(auth()->user()->esAdmin())
                <a href="{{ route('emprendedores.index') }}" class="btn-marca-primary btn-marca-lg">Ver Emprendedores</a>
                <a href="{{ route('programas.index') }}" class="btn-marca-outline btn-marca-lg">Programas de Formación</a>
            @else
                <a href="{{ route('programas.index') }}" class="btn-marca-primary btn-marca-lg">Ver Programas</a>
                @if(auth()->user()->emprendedor_id)
                    <a href="{{ route('emprendedores.show', auth()->user()->emprendedor_id) }}" class="btn-marca-outline btn-marca-lg">Mi Perfil</a>
                @endif
            @endif
        </div>
    @else
        {{-- Sin sesión: dos botones de inicio de sesión diferenciando rol --}}
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('login', ['rol' => 'emprendedor']) }}" class="btn-marca-primary btn-marca-lg">Ingresar como Emprendedor</a>
            <a href="{{ route('login', ['rol' => 'admin']) }}" class="btn-marca-outline btn-marca-lg">Ingresar como Administrador</a>
        </div>

        {{-- Enlace secundario para auto-registro de emprendedores --}}
        <p class="text-center mt-3 mb-0">
            <span class="text-muted">¿Eres nuevo emprendedor?</span>
            <a href="{{ route('register') }}" class="text-decoration-none ms-1">Crea tu cuenta</a>
        </p>
    @endauth
</div>
@endsection
