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
                <th>Cupo Máximo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Itera sobre cada programa y muestra una fila en la tabla --}}
            @foreach($programas as $programa)
            <tr>
                <td>{{ $programa->nombre }}</td>
                <td>{{ $programa->descripcion }}</td>
                <td>{{ $programa->cupo_maximo }}</td>
                <td>
                    {{-- Muestra badge verde si está activo, gris si está inactivo --}}
                    @if($programa->estado === 'activo')
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>
                <td>
                    {{-- Botón para ir al formulario de edición --}}
                    <a href="{{ route('programas.edit', $programa->id) }}" class="btn btn-sm btn-warning">Editar</a>

                    {{-- Formulario de eliminación: usa método DELETE con confirmación previa --}}
                    <form action="{{ route('programas.destroy', $programa->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este programa?')">Eliminar</button>
                    </form>
                </td>
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
