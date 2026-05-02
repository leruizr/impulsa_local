{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para registrar un nuevo emprendedor --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Emprendedores</h2>
    <a href="{{ route('emprendedores.create') }}" class="btn-marca-primary">Nuevo Emprendedor</a>
</div>

{{-- Tabla envuelta en un wrapper con bordes redondeados y sombra --}}
<div class="tabla-wrapper">
    <div class="table-responsive">
        <table class="tabla-marca">
            <thead>
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
                            <span class="badge-activo">Activo</span>
                        @else
                            <span class="badge-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        {{-- Los tres botones de acción se mantienen en línea horizontal --}}
                        <div class="d-flex gap-2">
                            {{-- Botón para ver el detalle del emprendedor con sus inscripciones --}}
                            <a href="{{ route('emprendedores.show', $emprendedor->id) }}" class="btn-marca-secondary btn-marca-sm">Ver inscripciones</a>

                            {{-- Botón para ir al formulario de edición --}}
                            <a href="{{ route('emprendedores.edit', $emprendedor->id) }}" class="btn-marca-secondary btn-marca-sm">Editar</a>

                            {{-- Formulario de eliminación: usa método DELETE con confirmación previa --}}
                            <form action="{{ route('emprendedores.destroy', $emprendedor->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-marca-danger btn-marca-sm" onclick="return confirm('¿Está seguro de eliminar este emprendedor?')">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Mensaje informativo cuando no hay emprendedores registrados --}}
@if($emprendedores->isEmpty())
    <div class="alert alert-info text-center mt-3">No hay emprendedores registrados.</div>
@endif
@endsection
