<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impulsa Local - Alcaldía de Ciudad Nueva</title>
    {{-- Hoja de estilos de Bootstrap 5 (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Iconos de Bootstrap (para el footer y la interfaz) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Hoja de estilos personalizada del proyecto --}}
    {{-- El parámetro ?v=... fuerza al navegador a recargar el CSS cuando cambia --}}
    <link href="{{ asset('css/estilos.css') }}?v={{ filemtime(public_path('css/estilos.css')) }}" rel="stylesheet">
</head>
<body>
    {{-- Barra de navegación blanca con el logo de marca a la izquierda y los enlaces a la derecha --}}
    <nav class="navbar navbar-expand-lg navbar-marca">
        <div class="container">
            {{-- Logo de marca: IMPULSA en azul + LOCAL en verde --}}
            <a class="navbar-brand logo-marca" href="{{ route('inicio') }}">
                <span class="logo-line logo-impulso">IMPULSA</span>
                <span class="logo-line logo-local">LOCAL</span>
            </a>

            {{-- Botón hamburguesa para pantallas pequeñas --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menú principal alineado a la derecha --}}
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

    {{-- Footer en tres columnas: iniciativa, datos de contacto y redes sociales --}}
    <footer class="footer-marca">
        <div class="container">
            <div class="row align-items-start">
                {{-- Columna izquierda: nombre de la iniciativa --}}
                <div class="col-md-4 mb-3">
                    <h5>Iniciativa Ciudad Nueva</h5>
                </div>

                {{-- Columna central: información de contacto --}}
                <div class="col-md-4 mb-3">
                    <p><i class="bi bi-house-door-fill me-2"></i>Secretaría de Comercio, Alcaldía Ciudad Nueva</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>impulsalocal@unad.co</p>
                    <p><i class="bi bi-telephone-fill me-2"></i>(601) 001 354 6555 44</p>
                </div>

                {{-- Columna derecha: íconos de redes sociales --}}
                <div class="col-md-4 mb-3 text-md-end">
                    <div class="social-icons justify-content-md-end">
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="X"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div>

            {{-- Línea inferior con los derechos reservados --}}
            <div class="footer-bottom">
                Todos los derechos reservados
            </div>
        </div>
    </footer>

    {{-- Script de Bootstrap 5 (necesario para el menú colapsable y alertas) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
