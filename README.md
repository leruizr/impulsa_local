# Impulsa Local - Alcaldia de Ciudad Nueva

Plataforma web desarrollada con **Laravel** para la digitalizacion y gestion de emprendedores locales (artesanos, panaderias, talleres y tiendas de barrio) del municipio de Ciudad Nueva. Permite registrar emprendedores, gestionar su informacion e inscribirlos en programas de formacion.

> Proyecto academico para la materia **Frameworks para Desarrollo Web - UNAD 2026**.

---

## Como usar el proyecto en tu equipo

### Requisitos previos

- **PHP** >= 8.3
- **Composer** (gestor de dependencias de PHP)
- **Node.js** y **npm** (para compilar los assets del frontend)
- **Laravel Herd** (recomendado, ya que el proyecto fue creado con Herd) o cualquier servidor local compatible (XAMPP, Laragon, etc.)

### Pasos de instalacion

1. **Clonar el repositorio:**

   ```bash
   git clone https://github.com/leruizr/impulsa_local.git
   cd impulsa_local
   ```

2. **Instalar dependencias de PHP:**

   ```bash
   composer install
   ```

3. **Instalar dependencias de Node:**

   ```bash
   npm install
   ```

4. **Configurar el archivo de entorno:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   > **Nota:** Configura las credenciales de tu base de datos MySQL en el `.env` antes de continuar:
   >
   > ```
   > DB_CONNECTION=mysql
   > DB_HOST=127.0.0.1
   > DB_PORT=3306
   > DB_DATABASE=impulsa_local
   > DB_USERNAME=root
   > DB_PASSWORD=tu_contraseña
   > ```
   >
   > Tambien crea la base de datos en MySQL antes de correr las migraciones:
   > ```sql
   > CREATE DATABASE impulsa_local;
   > ```

5. **Compilar los assets del frontend:**

   ```bash
   npm run build
   ```

   O para desarrollo con recarga automatica:

   ```bash
   npm run dev
   ```

6. **Iniciar el servidor:**

   Si usas **Laravel Herd**, el proyecto se sirve automaticamente en `http://impulsa_local.test`.

   Si no usas Herd, puedes levantar el servidor integrado de Laravel:

   ```bash
   php artisan serve
   ```

   Y acceder en `http://localhost:8000`.

---

## Estructura del proyecto (archivos principales)

A continuacion se listan los archivos donde se encuentra todo lo trabajado para este proyecto, organizados por carpeta:

### Rutas

| Archivo | Descripcion |
|---|---|
| `routes/web.php` | Define todas las rutas de la aplicacion (inicio, emprendedores y programas) |

### Controladores

| Archivo | Descripcion |
|---|---|
| `app/Http/Controllers/EmprendedorController.php` | Logica para listar, crear, editar y eliminar emprendedores. Lee y escribe en la base de datos a traves del modelo Emprendedor |
| `app/Http/Controllers/ProgramaFormacionController.php` | Logica para listar y crear programas de formacion. Contiene datos estaticos de ejemplo (pendiente conectar a BD) |

### Modelos

| Archivo | Descripcion |
|---|---|
| `app/Models/Emprendedor.php` | Modelo del emprendedor (campos: nombre, actividad economica, ubicacion, telefono, email, estado) |
| `app/Models/ProgramaFormacion.php` | Modelo del programa de formacion (campos: nombre, descripcion) |

### Vistas (Blade Templates)

| Archivo | Descripcion |
|---|---|
| `resources/views/layout.blade.php` | Plantilla principal (navbar, header y footer comunes a todas las paginas) |
| `resources/views/inicio.blade.php` | Pagina de inicio con descripcion del proyecto y botones de acceso |
| `resources/views/emprendedores/index.blade.php` | Tabla con el listado de todos los emprendedores |
| `resources/views/emprendedores/create.blade.php` | Formulario para registrar un nuevo emprendedor |
| `resources/views/emprendedores/edit.blade.php` | Formulario para editar un emprendedor existente |
| `resources/views/programas/index.blade.php` | Tabla con el listado de programas de formacion |
| `resources/views/programas/create.blade.php` | Formulario para crear un nuevo programa de formacion |

### Estilos

| Archivo | Descripcion |
|---|---|
| `public/css/estilos.css` | Hoja de estilos personalizada del proyecto |

### Base de datos

| Archivo | Descripcion |
|---|---|
| `database/migrations/2026_04_02_000001_create_emprendedores_table.php` | Crea la tabla `emprendedores` en la base de datos con todos sus campos. Se ejecuta con `php artisan migrate` |

---

## Arquitectura: Backend y Frontend

Este proyecto sigue el patron **MVC (Modelo - Vista - Controlador)** de Laravel, donde el backend y el frontend tienen responsabilidades separadas pero se comunican entre si.

---

### Backend

El backend es la parte del sistema que corre en el servidor. Se encarga de recibir las peticiones del navegador, procesarlas, manejar los datos y decidir que respuesta enviar. En este proyecto el backend esta escrito en **PHP con Laravel**.

#### Como funciona el flujo del backend

1. El navegador hace una peticion (ej: entrar a `/emprendedores`).
2. Laravel revisa `routes/web.php` y determina que controlador debe responder.
3. El controlador ejecuta la logica necesaria (obtener datos, validar formularios, etc.).
4. El controlador le pasa los datos a una vista para que se muestre en el navegador.

#### Archivos del backend

| Archivo | Rol | Como funciona |
|---|---|---|
| `routes/web.php` | **Enrutador** | Define que URL activa que controlador. Usa `Route::resource()` para generar automaticamente las 7 rutas CRUD (index, create, store, edit, update, destroy) |
| `app/Http/Controllers/EmprendedorController.php` | **Controlador** | Gestiona el CRUD completo de emprendedores conectado a la base de datos. Usa el modelo `Emprendedor` para leer, insertar, actualizar y eliminar registros |
| `app/Http/Controllers/ProgramaFormacionController.php` | **Controlador** | Gestiona los programas de formacion. Solo implementa index, create y store. Pendiente conectar a la base de datos |
| `app/Models/Emprendedor.php` | **Modelo** | Representa la tabla `emprendedores` en la base de datos. Define que campos se pueden guardar y es usado por el controlador para leer y escribir registros reales |
| `database/migrations/2026_04_02_000001_create_emprendedores_table.php` | **Migracion** | Crea la tabla `emprendedores` en MySQL con todos sus campos al correr `php artisan migrate` |

> Los programas de formacion aun manejan datos estaticos directamente en el controlador y no usan base de datos.

---

### Frontend

El frontend es la parte del sistema que ve y usa el usuario en el navegador. Se encarga de presentar la informacion de forma visual, mostrar formularios y enviar los datos ingresados al backend. En este proyecto el frontend usa **Blade (motor de plantillas de Laravel), Bootstrap 5 y CSS personalizado**.

#### Como funciona el flujo del frontend

1. El controlador (backend) llama a una vista y le pasa los datos necesarios.
2. Laravel procesa el archivo `.blade.php` y genera HTML puro.
3. El navegador recibe ese HTML junto con los estilos de Bootstrap y el CSS propio.
4. Cuando el usuario llena un formulario y hace clic en "Guardar", el navegador envia los datos al backend via POST.

#### Archivos del frontend

| Archivo | Rol | Como funciona |
|---|---|---|
| `resources/views/layout.blade.php` | **Plantilla base** | Define la estructura comun de todas las paginas: barra de navegacion, encabezado, area de mensajes de exito y pie de pagina. Las demas vistas la extienden con `@extends('layout')` |
| `resources/views/inicio.blade.php` | **Pagina de inicio** | Vista de bienvenida con la descripcion del proyecto y botones de acceso rapido a las dos secciones principales |
| `resources/views/emprendedores/index.blade.php` | **Listado** | Muestra todos los emprendedores en una tabla con sus datos. Incluye botones de editar y eliminar por cada fila. El boton eliminar usa un formulario con metodo DELETE |
| `resources/views/emprendedores/create.blade.php` | **Formulario de creacion** | Formulario con todos los campos del emprendedor. Usa `@error` para mostrar mensajes de validacion y `old()` para conservar los valores si el formulario es rechazado |
| `resources/views/emprendedores/edit.blade.php` | **Formulario de edicion** | Igual al de creacion pero los campos vienen pre-cargados con los datos actuales. Usa `@method('PUT')` para simular el metodo HTTP PUT |
| `resources/views/programas/index.blade.php` | **Listado** | Tabla con todos los programas de formacion disponibles |
| `resources/views/programas/create.blade.php` | **Formulario de creacion** | Formulario para registrar un nuevo programa con nombre y descripcion |
| `public/css/estilos.css` | **Estilos propios** | Define que el body ocupe toda la pantalla (`min-height: 100vh`) y que el footer siempre quede al fondo usando Flexbox |

---

## Paginas de la aplicacion

| URL | Descripcion |
|---|---|
| `/` | Pagina de inicio |
| `/emprendedores` | Listado de emprendedores |
| `/emprendedores/create` | Formulario para registrar emprendedor |
| `/emprendedores/{id}/edit` | Formulario para editar emprendedor |
| `/programas` | Listado de programas de formacion |
| `/programas/create` | Formulario para crear programa |

---

## Tecnologias utilizadas

- **Laravel 13** - Framework PHP
- **Bootstrap 5.3.3** - Framework CSS para la interfaz
- **Vite 8** - Herramienta de compilacion de assets
- **PHP 8.3+**

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
