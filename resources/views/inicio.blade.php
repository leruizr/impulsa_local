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

    {{-- Botones de acceso rápido a las dos secciones principales --}}
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('emprendedores.index') }}" class="btn-marca-primary btn-marca-lg">Ver Emprendedores</a>
        <a href="{{ route('programas.index') }}" class="btn-marca-outline btn-marca-lg">Programas de Formación</a>
    </div>
</div>
@endsection
