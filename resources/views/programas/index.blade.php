{{-- Hereda la estructura base definida en layout.blade.php --}}
@extends('layout')

@section('content')
{{-- Encabezado con el título y el botón para crear un nuevo programa (solo admin) --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title">Programas de Formación</h2>
    @auth
        @if(auth()->user()->esAdmin())
            <a href="{{ route('programas.create') }}" class="btn-marca-primary">Nuevo Programa</a>
        @endif
    @endauth
</div>

{{-- Tabla envuelta en un wrapper con bordes redondeados y sombra --}}
<div class="tabla-wrapper">
    <div class="table-responsive">
        <table class="tabla-marca">
            <thead>
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
                            <span class="badge-activo">Activo</span>
                        @else
                            <span class="badge-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        {{-- Los botones de acción se mantienen en línea horizontal --}}
                        <div class="d-flex gap-2">
                            {{-- Botón para ver inscritos: disponible para usuarios autenticados --}}
                            @auth
                                <a href="{{ route('programas.show', $programa->id) }}" class="btn-marca-secondary btn-marca-sm">Ver inscritos</a>
                            @endauth

                            {{-- Edición y eliminación solo para administradores --}}
                            @auth
                                @if(auth()->user()->esAdmin())
                                    <a href="{{ route('programas.edit', $programa->id) }}" class="btn-marca-secondary btn-marca-sm">Editar</a>

                                    {{-- Formulario de eliminación: usa método DELETE con confirmación previa --}}
                                    <form action="{{ route('programas.destroy', $programa->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-marca-danger btn-marca-sm" onclick="return confirm('¿Está seguro de eliminar este programa?')">Eliminar</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Mensaje informativo cuando no hay programas registrados --}}
@if($programas->isEmpty())
    <div class="alert alert-info text-center mt-3">No hay programas de formación registrados.</div>
@endif
@endsection
