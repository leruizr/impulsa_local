{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para registrar un nuevo emprendedor --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Emprendedores</h2>
    <a href="{{ route('emprendedores.create') }}" class="btn btn-primary">Nuevo Emprendedor</a>
</div>

{{-- Tabla responsive con todos los emprendedores registrados --}}
<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Actividad Económica</th>
                <th>Ubicación</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- Itera sobre cada emprendedor y muestra una fila en la tabla --}}
            @foreach($emprendedores as $emprendedor)
            <tr>
                <td>{{ $emprendedor->nombre }}</td>
                {{-- ucfirst pone en mayúscula la primera letra de la actividad --}}
                <td>{{ ucfirst($emprendedor->actividad_economica) }}</td>
                <td>{{ $emprendedor->ubicacion }}</td>
                <td>{{ $emprendedor->telefono }}</td>
                <td>{{ $emprendedor->email }}</td>
                <td>
                    {{-- Muestra badge verde si está activo, gris si está inactivo --}}
                    @if($emprendedor->estado === 'activo')
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>
                <td>
                    {{-- Botón para ir al formulario de edición --}}
                    <a href="{{ route('emprendedores.edit', $emprendedor->id) }}" class="btn btn-sm btn-warning">Editar</a>

                    {{-- Formulario de eliminación: usa método DELETE con confirmación previa --}}
                    <form action="{{ route('emprendedores.destroy', $emprendedor->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este emprendedor?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Mensaje informativo cuando no hay emprendedores registrados --}}
@if($emprendedores->isEmpty())
    <div class="alert alert-info text-center">No hay emprendedores registrados.</div>
@endif
@endsection
