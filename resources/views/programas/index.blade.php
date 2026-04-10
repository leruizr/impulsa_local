{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para crear un nuevo programa --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Programas de Formación</h2>
    <a href="{{ route('programas.create') }}" class="btn btn-primary">Nuevo Programa</a>
</div>

{{-- Tabla responsive con todos los programas de formación registrados --}}
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            {{-- Itera sobre cada programa y muestra una fila en la tabla --}}
            @foreach($programas as $programa)
            <tr>
                <td>{{ $programa->nombre }}</td>
                <td>{{ $programa->descripcion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mensaje informativo cuando no hay programas registrados --}}
@if($programas->isEmpty())
    <div class="alert alert-info text-center">No hay programas de formación registrados.</div>
@endif
@endsection
