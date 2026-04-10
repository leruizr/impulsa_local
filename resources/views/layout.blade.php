<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impulsa Local - Alcaldía de Ciudad Nueva</title>
    {{-- Hoja de estilos de Bootstrap 5 (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Hoja de estilos personalizada del proyecto --}}
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
</head>
<body>
    {{-- Barra de navegación principal con enlaces a las secciones del sistema --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('inicio') }}">Impulsa Local</a>
            {{-- Botón hamburguesa para pantallas pequeñas --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inicio') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('emprendedores.index') }}">Emprendedores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('programas.index') }}">Programas de Formación</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Encabezado secundario con el nombre de la institución --}}
    <header class="bg-light py-3 border-bottom">
        <div class="container">
            <h1 class="h4 mb-0">Impulsa Local - Alcaldía de Ciudad Nueva</h1>
        </div>
    </header>

    <main class="container py-4">
        {{-- Muestra mensajes de éxito (ej: "Emprendedor registrado exitosamente") --}}
        {{-- El mensaje se pasa desde el controlador usando ->with('success', '...') --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Espacio donde cada vista inyecta su contenido específico --}}
        @yield('content')
    </main>

    {{-- Pie de página con información del proyecto académico --}}
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p class="mb-0">Frameworks para desarrollo web - UNAD 2026</p>
        </div>
    </footer>

    {{-- Script de Bootstrap 5 (necesario para el menú colapsable y alertas) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
