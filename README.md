# Impulsa Local - Alcaldia de Ciudad Nueva

Plataforma web desarrollada con **Laravel** para la digitalizacion y gestion de emprendedores locales (artesanos, panaderias, talleres y tiendas de barrio) del municipio de Ciudad Nueva. Permite registrar emprendedores, gestionar su informacion e inscribirlos en programas de formacion, con autenticacion por roles (administrador y emprendedor) y modulo de reportes.

> Proyecto academico para la materia **Frameworks para Desarrollo Web - UNAD 2026**.

---

## Funcionalidades implementadas

| # | Funcionalidad |
|---|---|
| 1 | Pagina de inicio con opcion para iniciar sesion diferenciando emprendedor y administrador |
| 2 | Opcion de registrar nuevos emprendedores (auto-registro publico y registro manual por el administrador) |
| 3 | Opcion para que el emprendedor actualice sus propios datos |
| 4 | CRUD completo de programas de formacion por parte del administrador |
| 5 | Inscripcion a programas de formacion disponibles por parte del emprendedor |
| 6 | Visualizacion y consulta publica de los programas de formacion disponibles |
| 7 | Visualizacion de los emprendedores inscritos en cada programa de formacion |
| 8 | Reporte de emprendedores activos en el sistema (con opcion imprimir / guardar como PDF) |
| 9 | Reporte de emprendedores inscritos en cada programa de formacion (con opcion imprimir / guardar como PDF) |

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

8. **Ejecutar los seeders** (carga datos iniciales: admin, emprendedores y programas de ejemplo):

   ```bash
   php artisan db:seed
   ```

9. **Compilar los assets del frontend:**

   ```bash
   npm run build
   ```

10. **Iniciar el servidor:**

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

5. **Ejecutar seeders nuevos** (solo si se necesita poblar datos iniciales como el usuario admin):

   ```bash
   php artisan db:seed --class=UsuarioSeeder
   ```

6. **Recompilar los assets** (solo si hubo cambios en CSS o JS):

   ```bash
   npm run build
   ```

   > Si el servidor ya estaba corriendo no necesitas reiniciarlo. Con Herd los cambios se reflejan automaticamente.

---

## Credenciales por defecto

Al ejecutar `php artisan db:seed` se crean los siguientes usuarios de prueba:

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | `admin@impulsalocal.co` | `admin1234` |
| Emprendedor (ejemplo) | `luz.moreno@correo.com` | `emprendedor1234` |
| Emprendedor (ejemplo) | `carlos.patino@correo.com` | `emprendedor1234` |

> Todos los emprendedores cargados por el `EmprendedorSeeder` reciben un usuario asociado con la contraseña `emprendedor1234`. Nuevos emprendedores pueden registrarse desde `/registro`.

---

## Estructura del proyecto (archivos principales)

A continuacion se listan los archivos donde se encuentra todo lo trabajado para este proyecto, organizados por carpeta:

### Rutas

| Archivo | Descripcion |
|---|---|
| `routes/web.php` | Define todas las rutas de la aplicacion: inicio, autenticacion, emprendedores, programas, inscripciones y reportes. Aplica middlewares `auth` y `rol:admin\|emprendedor` para restringir el acceso |

### Controladores

| Archivo | Descripcion |
|---|---|
| `app/Http/Controllers/AuthController.php` | Maneja inicio de sesion, cierre de sesion y auto-registro de emprendedores (crea Emprendedor + User en una transaccion) |
| `app/Http/Controllers/EmprendedorController.php` | Logica CRUD de emprendedores. Aplica autorizacion para que un emprendedor solo pueda editar su propio registro |
| `app/Http/Controllers/ProgramaFormacionController.php` | Logica CRUD completa para programas de formacion. Incluye el metodo `show()` con la lista de emprendedores inscritos |
| `app/Http/Controllers/InscripcionController.php` | Inscripcion y cancelacion de inscripciones de emprendedores en programas. Valida que el emprendedor solo opere sobre su propio registro |
| `app/Http/Controllers/ReporteController.php` | Genera los reportes administrativos: emprendedores activos e inscripciones por programa |

### Middleware

| Archivo | Descripcion |
|---|---|
| `app/Http/Middleware/RolMiddleware.php` | Middleware personalizado que restringe rutas segun el rol del usuario autenticado (`rol:admin`, `rol:admin,emprendedor`). Registrado como alias `rol` en `bootstrap/app.php` |

### Modelos

| Archivo | Descripcion |
|---|---|
| `app/Models/User.php` | Modelo del usuario autenticable. Campos `rol` (admin/emprendedor) y `emprendedor_id` (relacion opcional con Emprendedor). Helpers `esAdmin()` y `esEmprendedor()` |
| `app/Models/Emprendedor.php` | Modelo del emprendedor (nombre, actividad economica, ubicacion, telefono, email, estado). Relacion muchos a muchos con ProgramaFormacion |
| `app/Models/ProgramaFormacion.php` | Modelo del programa de formacion (nombre, descripcion, cupo_maximo, estado). Relacion muchos a muchos con Emprendedor |

### Vistas (Blade Templates)

| Archivo | Descripcion |
|---|---|
| `resources/views/layout.blade.php` | Plantilla principal (navbar dinamico segun rol, encabezado y footer). Muestra/oculta enlaces y boton de cerrar sesion segun el estado de autenticacion |
| `resources/views/inicio.blade.php` | Pagina de inicio. Sin sesion muestra botones de "Ingresar como Emprendedor" / "Ingresar como Administrador" y enlace de registro. Con sesion muestra accesos rapidos segun rol |
| `resources/views/auth/login.blade.php` | Formulario de inicio de sesion con pestañas para seleccionar rol (Emprendedor / Administrador) |
| `resources/views/auth/register.blade.php` | Formulario de auto-registro publico para emprendedores. Crea Emprendedor + Usuario asociado |
| `resources/views/emprendedores/index.blade.php` | Listado de emprendedores (solo admin) con acciones de ver detalle, editar y eliminar |
| `resources/views/emprendedores/create.blade.php` | Formulario para registrar un nuevo emprendedor (solo admin) |
| `resources/views/emprendedores/edit.blade.php` | Formulario para editar un emprendedor. El campo "Estado" solo se muestra al administrador |
| `resources/views/emprendedores/show.blade.php` | Detalle del emprendedor con sus programas inscritos y formulario para inscribirlo en uno nuevo |
| `resources/views/programas/index.blade.php` | Listado publico de programas. El boton "Ver inscritos" requiere sesion; "Nuevo", "Editar" y "Eliminar" solo son visibles al admin |
| `resources/views/programas/create.blade.php` | Formulario para crear un programa (solo admin) |
| `resources/views/programas/edit.blade.php` | Formulario para editar un programa (solo admin) |
| `resources/views/programas/show.blade.php` | Detalle del programa con la tabla de emprendedores inscritos, fechas y estado de cada inscripcion |
| `resources/views/reportes/index.blade.php` | Portada del modulo de reportes (solo admin) |
| `resources/views/reportes/emprendedores_activos.blade.php` | Reporte de emprendedores activos en el sistema con opcion "Imprimir / PDF" |
| `resources/views/reportes/inscripciones_programa.blade.php` | Reporte de emprendedores inscritos en cada programa con opcion "Imprimir / PDF" |

### Estilos

| Archivo | Descripcion |
|---|---|
| `public/css/estilos.css` | Hoja de estilos personalizada del proyecto. Incluye reglas `@media print` que ocultan navbar, footer y botones al imprimir, y muestran un encabezado institucional en los reportes |

### Base de datos

| Archivo | Descripcion |
|---|---|
| `database/migrations/0001_01_01_000000_create_users_table.php` | Crea la tabla `users` de Laravel (autenticacion) |
| `database/migrations/2026_04_02_000001_create_emprendedores_table.php` | Crea la tabla `emprendedores` con todos sus campos |
| `database/migrations/2026_04_02_000002_create_programas_formacion_table.php` | Crea la tabla `programas_formacion` con los campos basicos |
| `database/migrations/2026_04_02_000003_create_emprendedor_programa_table.php` | Crea la tabla pivote `emprendedor_programa` para la relacion muchos a muchos |
| `database/migrations/2026_05_02_000001_add_cupo_maximo_and_estado_to_programas_formacion_table.php` | Agrega los campos `cupo_maximo` y `estado` a la tabla de programas |
| `database/migrations/2026_05_02_000002_add_estado_and_unique_to_emprendedor_programa_table.php` | Agrega el campo `estado` y el indice unico a la tabla pivote |
| `database/migrations/2026_05_18_000001_add_rol_and_emprendedor_id_to_users_table.php` | Migracion aditiva: agrega `rol` (enum admin/emprendedor) y `emprendedor_id` (FK opcional) a la tabla `users` |

### Seeders

| Archivo | Descripcion |
|---|---|
| `database/seeders/DatabaseSeeder.php` | Orquesta la ejecucion de los seeders en orden |
| `database/seeders/EmprendedorSeeder.php` | Inserta emprendedores de ejemplo |
| `database/seeders/ProgramaFormacionSeeder.php` | Inserta programas de formacion de ejemplo |
| `database/seeders/UsuarioSeeder.php` | Crea el usuario administrador por defecto y un usuario por cada emprendedor existente |

---

## Arquitectura: Backend y Frontend

Este proyecto sigue el patron **MVC (Modelo - Vista - Controlador)** de Laravel, donde el backend y el frontend tienen responsabilidades separadas pero se comunican entre si.

---

### Backend

El backend es la parte del sistema que corre en el servidor. Se encarga de recibir las peticiones del navegador, procesarlas, manejar los datos y decidir que respuesta enviar. En este proyecto el backend esta escrito en **PHP con Laravel**.

#### Como funciona el flujo del backend

1. El navegador hace una peticion (ej: entrar a `/emprendedores`).
2. Laravel revisa `routes/web.php` y determina que controlador debe responder.
3. Si la ruta esta protegida, ejecutan los middlewares (`auth` y `rol`) antes de llegar al controlador.
4. El controlador ejecuta la logica necesaria (obtener datos, validar formularios, autorizar, etc.).
5. El controlador le pasa los datos a una vista para que se muestre en el navegador.

#### Archivos del backend

| Archivo | Rol | Como funciona |
|---|---|---|
| `routes/web.php` | **Enrutador** | Define que URL activa que controlador. Las rutas estan agrupadas con middlewares `auth` y `rol:admin\|emprendedor` para restringir el acceso por rol |
| `bootstrap/app.php` | **Configuracion** | Registra el alias `rol` que permite usar `RolMiddleware` desde las rutas |
| `app/Http/Middleware/RolMiddleware.php` | **Middleware** | Verifica que el usuario autenticado tenga uno de los roles permitidos por la ruta; en caso contrario aborta con 403 |
| `app/Http/Controllers/AuthController.php` | **Controlador** | Procesa el login (verificando email, password y rol), el logout y el auto-registro de emprendedor (crea Emprendedor + User en una transaccion) |
| `app/Http/Controllers/EmprendedorController.php` | **Controlador** | Gestiona el CRUD completo de emprendedores. Incluye el metodo `show()` con sus programas inscritos y la autorizacion para que un emprendedor solo edite su propio registro |
| `app/Http/Controllers/ProgramaFormacionController.php` | **Controlador** | Gestiona el CRUD completo de programas. El metodo `show()` carga la lista de emprendedores inscritos en el programa |
| `app/Http/Controllers/InscripcionController.php` | **Controlador** | Gestiona la inscripcion y cancelacion de inscripciones. Verifica que un emprendedor solo opere sobre su propio registro |
| `app/Http/Controllers/ReporteController.php` | **Controlador** | Construye los datos para el reporte de emprendedores activos y para el reporte de inscripciones por programa |
| `app/Models/User.php` | **Modelo** | Representa a los usuarios del sistema con su rol y la relacion opcional con un emprendedor |
| `app/Models/Emprendedor.php` | **Modelo** | Representa la tabla `emprendedores`. Define la relacion muchos a muchos con ProgramaFormacion |
| `app/Models/ProgramaFormacion.php` | **Modelo** | Representa la tabla `programas_formacion`. Define la relacion muchos a muchos con Emprendedor |
| `database/migrations/2026_04_02_000001_create_emprendedores_table.php` | **Migracion** | Crea la tabla `emprendedores` |
| `database/migrations/2026_04_02_000002_create_programas_formacion_table.php` | **Migracion** | Crea la tabla `programas_formacion` |
| `database/migrations/2026_04_02_000003_create_emprendedor_programa_table.php` | **Migracion** | Crea la tabla pivote para la relacion muchos a muchos |
| `database/migrations/2026_05_02_000001_add_cupo_maximo_and_estado_to_programas_formacion_table.php` | **Migracion** | Agrega `cupo_maximo` y `estado` a la tabla de programas |
| `database/migrations/2026_05_02_000002_add_estado_and_unique_to_emprendedor_programa_table.php` | **Migracion** | Agrega `estado` e indice unico a la pivote |
| `database/migrations/2026_05_18_000001_add_rol_and_emprendedor_id_to_users_table.php` | **Migracion** | Agrega `rol` y `emprendedor_id` a la tabla `users` para soportar autenticacion por roles |
| `database/seeders/UsuarioSeeder.php` | **Seeder** | Crea el admin por defecto y los usuarios emprendedores asociados a los registros sembrados |

---

### Frontend

El frontend es la parte del sistema que ve y usa el usuario en el navegador. Se encarga de presentar la informacion de forma visual, mostrar formularios y enviar los datos ingresados al backend. En este proyecto el frontend usa **Blade (motor de plantillas de Laravel), Bootstrap 5 y CSS personalizado**.

#### Como funciona el flujo del frontend

1. El controlador (backend) llama a una vista y le pasa los datos necesarios.
2. Laravel procesa el archivo `.blade.php` y genera HTML puro.
3. El navegador recibe ese HTML junto con los estilos de Bootstrap y el CSS propio.
4. Cuando el usuario llena un formulario y hace clic en "Guardar", el navegador envia los datos al backend via POST.
5. Las vistas usan directivas `@auth` y verificaciones `auth()->user()->esAdmin()` para mostrar u ocultar elementos segun el rol.

#### Archivos del frontend

| Archivo | Rol | Como funciona |
|---|---|---|
| `resources/views/layout.blade.php` | **Plantilla base** | Define la estructura comun de todas las paginas. El navbar es dinamico: muestra "Emprendedores" y "Reportes" solo al admin, el saludo con el nombre del usuario y el boton "Cerrar sesion" cuando hay sesion |
| `resources/views/inicio.blade.php` | **Pagina de inicio** | Vista de bienvenida. Sin sesion ofrece dos botones de inicio de sesion (por rol) y un enlace de registro. Con sesion ofrece accesos rapidos segun el rol del usuario |
| `resources/views/auth/login.blade.php` | **Login** | Formulario con pestañas para seleccionar el rol (Emprendedor / Administrador) y campos de email y contraseña |
| `resources/views/auth/register.blade.php` | **Registro emprendedor** | Formulario publico que recoge los datos del emprendedor y crea simultaneamente el registro en `emprendedores` y el usuario en `users` |
| `resources/views/emprendedores/index.blade.php` | **Listado** | Tabla con todos los emprendedores y acciones de ver detalle, editar y eliminar. Solo accesible al administrador |
| `resources/views/emprendedores/create.blade.php` | **Formulario de creacion** | Formulario con todos los campos del emprendedor. Usa `@error` para mostrar mensajes de validacion y `old()` para conservar valores |
| `resources/views/emprendedores/edit.blade.php` | **Formulario de edicion** | Igual al de creacion pero los campos vienen pre-cargados. El campo "Estado" se muestra unicamente al administrador. Usa `@method('PUT')` |
| `resources/views/emprendedores/show.blade.php` | **Detalle e inscripciones** | Datos del emprendedor, tabla de programas inscritos (con boton para cancelar inscripcion) y tabla de programas disponibles con boton "Inscribirse" |
| `resources/views/programas/index.blade.php` | **Listado publico** | Tabla con todos los programas. El boton "Ver inscritos" se muestra a usuarios autenticados; "Nuevo Programa", "Editar" y "Eliminar" solo al administrador |
| `resources/views/programas/create.blade.php` | **Formulario de creacion** | Formulario para registrar un programa con nombre, descripcion, cupo maximo y estado |
| `resources/views/programas/edit.blade.php` | **Formulario de edicion** | Igual al de creacion pero los campos vienen pre-cargados. Usa `@method('PUT')` |
| `resources/views/programas/show.blade.php` | **Detalle e inscritos** | Datos del programa y tabla con los emprendedores inscritos, fecha y estado de cada inscripcion |
| `resources/views/reportes/index.blade.php` | **Portada de reportes** | Tarjetas con accesos al reporte de emprendedores activos y al reporte de inscripciones por programa |
| `resources/views/reportes/emprendedores_activos.blade.php` | **Reporte 1** | Listado tabular de emprendedores activos con boton "Imprimir / PDF" (`window.print()`) y encabezado institucional para impresion |
| `resources/views/reportes/inscripciones_programa.blade.php` | **Reporte 2** | Detalle por programa con la cantidad de inscritos, sus datos y boton "Imprimir / PDF" |
| `public/css/estilos.css` | **Estilos propios** | Estilos del proyecto. Incluye un bloque `@media print` que oculta navbar, footer y botones marcados con `.no-print`, y revela el encabezado `.reporte-encabezado` solo al imprimir |

---

## Paginas de la aplicacion

| URL | Metodo | Rol requerido | Descripcion |
|---|---|---|---|
| `/` | GET | publico | Pagina de inicio |
| `/login` | GET | publico | Formulario de inicio de sesion (pestañas Emprendedor / Administrador) |
| `/login` | POST | publico | Procesa el inicio de sesion |
| `/logout` | POST | autenticado | Cierra la sesion del usuario |
| `/registro` | GET | publico | Formulario de auto-registro para emprendedores |
| `/registro` | POST | publico | Crea el emprendedor y el usuario asociado |
| `/programas` | GET | publico | Listado de programas de formacion |
| `/programas/{id}` | GET | autenticado | Detalle del programa con sus emprendedores inscritos |
| `/programas/create` | GET | admin | Formulario para crear programa |
| `/programas` | POST | admin | Guarda el nuevo programa |
| `/programas/{id}/edit` | GET | admin | Formulario para editar programa |
| `/programas/{id}` | PUT | admin | Actualiza el programa |
| `/programas/{id}` | DELETE | admin | Elimina el programa |
| `/emprendedores` | GET | admin | Listado de emprendedores |
| `/emprendedores/create` | GET | admin | Formulario para registrar emprendedor |
| `/emprendedores` | POST | admin | Guarda el nuevo emprendedor |
| `/emprendedores/{id}` | GET | admin o dueño | Detalle del emprendedor con sus programas inscritos y formulario para inscribirlo en uno nuevo |
| `/emprendedores/{id}/edit` | GET | admin o dueño | Formulario para editar emprendedor |
| `/emprendedores/{id}` | PUT | admin o dueño | Actualiza el emprendedor (el campo `estado` solo aplica si lo modifica el admin) |
| `/emprendedores/{id}` | DELETE | admin | Elimina el emprendedor |
| `/emprendedores/{id}/inscripciones` | POST | admin o dueño | Inscribe al emprendedor en un programa |
| `/emprendedores/{id}/inscripciones/{programa}` | DELETE | admin o dueño | Cancela la inscripcion del emprendedor en un programa |
| `/reportes` | GET | admin | Portada del modulo de reportes |
| `/reportes/emprendedores-activos` | GET | admin | Reporte de emprendedores activos |
| `/reportes/inscripciones` | GET | admin | Reporte de inscripciones por programa |

---

## Tecnologias utilizadas

- **Laravel 13** - Framework PHP
- **Bootstrap 5.3.3** - Framework CSS para la interfaz
- **Bootstrap Icons 1.11.3** - Iconografia (botones y footer)
- **Vite 8** - Herramienta de compilacion de assets
- **PHP 8.3+**
- **MySQL** - Base de datos relacional

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
