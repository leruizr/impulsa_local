@extends('layout')

@section('content')
<div class="text-center py-5">
    <h2 class="mb-4">Bienvenido a Impulsa Local</h2>
    <p class="lead mb-4">
        Programa de la Alcaldía de Ciudad Nueva para la digitalización y gestión
        de emprendedores locales: artesanos, panaderías, talleres y tiendas de barrio.
    </p>
    <hr class="my-4">
    <p>
        Esta plataforma permite registrar emprendedores, gestionar su información
        e inscribirlos en programas de formación que fortalezcan sus negocios
        y contribuyan al desarrollo económico local.
    </p>
    <div class="mt-4">
        <a href="{{ route('emprendedores.index') }}" class="btn btn-primary btn-lg me-2">Ver Emprendedores</a>
        <a href="{{ route('programas.index') }}" class="btn btn-outline-primary btn-lg">Programas de Formación</a>
    </div>
</div>
@endsection
