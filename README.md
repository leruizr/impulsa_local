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

   > **Nota:** Este proyecto utiliza datos estaticos (no requiere base de datos). Asegurate de que el archivo `.env` tenga los siguientes valores para evitar errores de conexion:
   >
   > ```
   > SESSION_DRIVER=file
   > QUEUE_CONNECTION=sync
   > CACHE_STORE=file
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
| `app/Http/Controllers/EmprendedorController.php` | Logica para listar, crear, editar y eliminar emprendedores. Contiene los datos estaticos de ejemplo |
| `app/Http/Controllers/ProgramaFormacionController.php` | Logica para listar y crear programas de formacion. Contiene los datos estaticos de ejemplo |

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

### Migraciones y Seeders

| Archivo | Descripcion |
|---|---|
| `database/migrations/` | Definicion de las tablas (emprendedores, programas_formacion, emprendedor_programa) |
| `database/seeders/EmprendedorSeeder.php` | Datos de ejemplo de emprendedores |
| `database/seeders/ProgramaFormacionSeeder.php` | Datos de ejemplo de programas de formacion |

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
