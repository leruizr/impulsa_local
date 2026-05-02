# Impulsa Local - Alcaldia de Ciudad Nueva

Plataforma web desarrollada con **Laravel** para la digitalizacion y gestion de emprendedores locales (artesanos, panaderias, talleres y tiendas de barrio) del municipio de Ciudad Nueva. Permite registrar emprendedores, gestionar su informacion e inscribirlos en programas de formacion.

> Proyecto academico para la materia **Frameworks para Desarrollo Web - UNAD 2026**.

---

## Como usar el proyecto en tu equipo

### Requisitos previos

Antes de comenzar asegurate de tener instalado en tu equipo:

- **PHP** >= 8.3
- **Composer** (gestor de dependencias de PHP)
- **Node.js** y **npm** (para compilar los assets del frontend)
- **MySQL** (base de datos)
- **Laravel Herd** (recomendado) o cualquier servidor local compatible (XAMPP, Laragon, etc.)

---

### Opcion A — No tengo el proyecto todavia (primer uso)

Sigue estos pasos si vas a descargar el proyecto por primera vez.

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

4. **Crear el archivo de entorno y generar la clave de la aplicacion:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar la base de datos en el archivo `.env`:**

   Abre el archivo `.env` y actualiza estas lineas con tus credenciales de MySQL:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=impulsa_local
   DB_USERNAME=root
   DB_PASSWORD=tu_contraseña
   ```

6. **Crear la base de datos en MySQL:**

   Desde MySQL Workbench, HeidiSQL o la terminal ejecuta:

   ```sql
   CREATE DATABASE impulsa_local;
   ```

7. **Ejecutar las migraciones** (crea las tablas en la base de datos):

   ```bash
   php artisan migrate
   ```

8. **Compilar los assets del frontend:**

   ```bash
   npm run build
   ```

9. **Iniciar el servidor:**

   Si usas **Laravel Herd**, el proyecto se sirve automaticamente en `http://impulsa_local.test`.

   Si no usas Herd, ejecuta:

   ```bash
   php artisan serve
   ```

   Y accede en `http://localhost:8000`.

---

### Opcion B — Ya tengo el proyecto descargado (actualizaciones)

Sigue estos pasos si ya clonaste el proyecto anteriormente y solo quieres actualizar cambios recientes.

1. **Obtener los ultimos cambios del repositorio:**

   ```bash
   git pull
   ```

2. **Actualizar dependencias de PHP** (solo si hubo cambios en `composer.json`):

   ```bash
   composer install
   ```

3. **Actualizar dependencias de Node** (solo si hubo cambios en `package.json`):

   ```bash
   npm install
   ```

4. **Ejecutar migraciones pendientes** (solo si se agregaron nuevas migraciones):

   ```bash
   php artisan migrate
   ```

5. **Recompilar los assets** (solo si hubo cambios en CSS o JS):

   ```bash
   npm run build
   ```

   > Si el servidor ya estaba corriendo no necesitas reiniciarlo. Con Herd los cambios se reflejan automaticamente.

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
| `app/Http/Controllers/EmprendedorController.php` | Logica para listar, ver detalle, crear, editar y eliminar emprendedores. Lee y escribe en la base de datos a traves del modelo Emprendedor |
| `app/Http/Controllers/ProgramaFormacionController.php` | Logica CRUD completa para programas de formacion. Lee y escribe en la base de datos a traves del modelo ProgramaFormacion |
| `app/Http/Controllers/InscripcionController.php` | Logica para inscribir emprendedores en programas de formacion y cancelar inscripciones. Trabaja sobre la tabla pivote `emprendedor_programa` |

### Modelos

| Archivo | Descripcion |
|---|---|
| `app/Models/Emprendedor.php` | Modelo del emprendedor (campos: nombre, actividad economica, ubicacion, telefono, email, estado). Define la relacion muchos a muchos con ProgramaFormacion |
| `app/Models/ProgramaFormacion.php` | Modelo del programa de formacion (campos: nombre, descripcion, cupo_maximo, estado). Define la relacion muchos a muchos con Emprendedor |

### Vistas (Blade Templates)

| Archivo | Descripcion |
|---|---|
| `resources/views/layout.blade.php` | Plantilla principal (navbar, header y footer comunes a todas las paginas) |
| `resources/views/inicio.blade.php` | Pagina de inicio con descripcion del proyecto y botones de acceso |
| `resources/views/emprendedores/index.blade.php` | Tabla con el listado de todos los emprendedores |
| `resources/views/emprendedores/create.blade.php` | Formulario para registrar un nuevo emprendedor |
| `resources/views/emprendedores/edit.blade.php` | Formulario para editar un emprendedor existente |
| `resources/views/emprendedores/show.blade.php` | Detalle del emprendedor con sus programas inscritos y formulario para inscribirlo en uno nuevo |
| `resources/views/programas/index.blade.php` | Tabla con el listado de programas de formacion |
| `resources/views/programas/create.blade.php` | Formulario para crear un nuevo programa de formacion |
| `resources/views/programas/edit.blade.php` | Formulario para editar un programa de formacion existente |

### Estilos

| Archivo | Descripcion |
|---|---|
| `public/css/estilos.css` | Hoja de estilos personalizada del proyecto |

### Base de datos

| Archivo | Descripcion |
|---|---|
| `database/migrations/2026_04_02_000001_create_emprendedores_table.php` | Crea la tabla `emprendedores` en la base de datos con todos sus campos. Se ejecuta con `php artisan migrate` |
| `database/migrations/2026_04_02_000002_create_programas_formacion_table.php` | Crea la tabla `programas_formacion` con los campos basicos (id, nombre, descripcion) |
| `database/migrations/2026_04_02_000003_create_emprendedor_programa_table.php` | Crea la tabla pivote `emprendedor_programa` para la relacion muchos a muchos entre emprendedores y programas |
| `database/migrations/2026_05_02_000001_add_cupo_maximo_and_estado_to_programas_formacion_table.php` | Agrega los campos `cupo_maximo` y `estado` a la tabla `programas_formacion` |
| `database/migrations/2026_05_02_000002_add_estado_and_unique_to_emprendedor_programa_table.php` | Agrega el campo `estado` a la pivote y un indice unico que evita inscripciones duplicadas |

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
| `routes/web.php` | **Enrutador** | Define que URL activa que controlador. Usa `Route::resource()` para generar automaticamente las 7 rutas CRUD (index, create, store, show, edit, update, destroy) y agrega rutas adicionales para inscripciones |
| `app/Http/Controllers/EmprendedorController.php` | **Controlador** | Gestiona el CRUD completo de emprendedores conectado a la base de datos. Incluye el metodo `show()` que muestra el detalle del emprendedor con sus programas inscritos |
| `app/Http/Controllers/ProgramaFormacionController.php` | **Controlador** | Gestiona el CRUD completo de programas de formacion conectado a la base de datos a traves del modelo `ProgramaFormacion` |
| `app/Http/Controllers/InscripcionController.php` | **Controlador** | Gestiona la inscripcion y cancelacion de inscripciones de emprendedores en programas. Usa la relacion muchos a muchos definida en los modelos |
| `app/Models/Emprendedor.php` | **Modelo** | Representa la tabla `emprendedores` en la base de datos. Define la relacion muchos a muchos con ProgramaFormacion a traves de la pivote |
| `app/Models/ProgramaFormacion.php` | **Modelo** | Representa la tabla `programas_formacion`. Define la relacion muchos a muchos con Emprendedor a traves de la pivote |
| `database/migrations/2026_04_02_000001_create_emprendedores_table.php` | **Migracion** | Crea la tabla `emprendedores` en MySQL con todos sus campos al correr `php artisan migrate` |
| `database/migrations/2026_04_02_000002_create_programas_formacion_table.php` | **Migracion** | Crea la tabla `programas_formacion` con los campos basicos |
| `database/migrations/2026_04_02_000003_create_emprendedor_programa_table.php` | **Migracion** | Crea la tabla pivote para la relacion muchos a muchos |
| `database/migrations/2026_05_02_000001_add_cupo_maximo_and_estado_to_programas_formacion_table.php` | **Migracion** | Agrega los campos `cupo_maximo` y `estado` a la tabla de programas |
| `database/migrations/2026_05_02_000002_add_estado_and_unique_to_emprendedor_programa_table.php` | **Migracion** | Agrega el campo `estado` y el indice unico a la tabla pivote |

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
| `resources/views/emprendedores/index.blade.php` | **Listado** | Muestra todos los emprendedores en una tabla con sus datos. Incluye botones de ver inscripciones, editar y eliminar por cada fila. El boton eliminar usa un formulario con metodo DELETE |
| `resources/views/emprendedores/create.blade.php` | **Formulario de creacion** | Formulario con todos los campos del emprendedor. Usa `@error` para mostrar mensajes de validacion y `old()` para conservar los valores si el formulario es rechazado |
| `resources/views/emprendedores/edit.blade.php` | **Formulario de edicion** | Igual al de creacion pero los campos vienen pre-cargados con los datos actuales. Usa `@method('PUT')` para simular el metodo HTTP PUT |
| `resources/views/emprendedores/show.blade.php` | **Detalle e inscripciones** | Muestra los datos del emprendedor en una tarjeta, la tabla de programas inscritos (con boton para cancelar inscripcion) y un formulario para inscribirlo en un programa nuevo |
| `resources/views/programas/index.blade.php` | **Listado** | Tabla con todos los programas de formacion disponibles, con sus columnas de cupo maximo, estado y botones de editar y eliminar |
| `resources/views/programas/create.blade.php` | **Formulario de creacion** | Formulario para registrar un nuevo programa con nombre, descripcion, cupo maximo y estado |
| `resources/views/programas/edit.blade.php` | **Formulario de edicion** | Igual al de creacion pero los campos vienen pre-cargados con los datos actuales. Usa `@method('PUT')` |
| `public/css/estilos.css` | **Estilos propios** | Define que el body ocupe toda la pantalla (`min-height: 100vh`) y que el footer siempre quede al fondo usando Flexbox |

---

## Paginas de la aplicacion

| URL | Descripcion |
|---|---|
| `/` | Pagina de inicio |
| `/emprendedores` | Listado de emprendedores |
| `/emprendedores/create` | Formulario para registrar emprendedor |
| `/emprendedores/{id}` | Detalle del emprendedor con sus programas inscritos y formulario para inscribirlo en uno nuevo |
| `/emprendedores/{id}/edit` | Formulario para editar emprendedor |
| `/programas` | Listado de programas de formacion |
| `/programas/create` | Formulario para crear programa |
| `/programas/{id}/edit` | Formulario para editar programa |
| `POST /emprendedores/{id}/inscripciones` | Inscribe al emprendedor en un programa de formacion |
| `DELETE /emprendedores/{id}/inscripciones/{programa}` | Cancela la inscripcion del emprendedor en un programa |

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
