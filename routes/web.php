<?php

// Importación de los controladores usados en las rutas
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ProgramaFormacionController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// Ruta de la página de inicio (bienvenida) - accesible sin sesión
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// -----------------------------------------------------------------------------
// Rutas de autenticación (login, logout y registro de emprendedor)
// -----------------------------------------------------------------------------
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auto-registro de emprendedores
Route::get('/registro',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.store');

// -----------------------------------------------------------------------------
// Visualización de programas (req #6: pública para consulta)
// El index y el show de programas no requieren autenticación.
// -----------------------------------------------------------------------------
Route::get('/programas',         [ProgramaFormacionController::class, 'index'])->name('programas.index');

// -----------------------------------------------------------------------------
// Rutas que requieren sesión iniciada
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // CRUD completo de Programas de Formación - solo administradores (req #4)
    Route::middleware('rol:admin')->group(function () {
        Route::get('/programas/create',         [ProgramaFormacionController::class, 'create'])->name('programas.create');
        Route::post('/programas',               [ProgramaFormacionController::class, 'store'])->name('programas.store');
        Route::get('/programas/{programa}/edit',[ProgramaFormacionController::class, 'edit'])->name('programas.edit');
        Route::put('/programas/{programa}',     [ProgramaFormacionController::class, 'update'])->name('programas.update');
        Route::delete('/programas/{programa}',  [ProgramaFormacionController::class, 'destroy'])->name('programas.destroy');

        // Reportes administrativos (req #8 y #9)
        Route::prefix('reportes')->name('reportes.')->group(function () {
            Route::get('/',                       [ReporteController::class, 'index'])->name('index');
            Route::get('/emprendedores-activos',  [ReporteController::class, 'emprendedoresActivos'])->name('emprendedores-activos');
            Route::get('/inscripciones',          [ReporteController::class, 'inscripcionesPorPrograma'])->name('inscripciones');
        });
    });

    // Gestión de emprendedores
    // - El listado y la eliminación quedan reservadas al administrador.
    // - El admin también puede registrar nuevos emprendedores manualmente.
    // - El detalle, edición y actualización quedan abiertos a ambos roles;
    //   el propio controlador verifica que un emprendedor solo opere sobre su propio registro.
    Route::middleware('rol:admin')->group(function () {
        Route::get('/emprendedores',                [EmprendedorController::class, 'index'])->name('emprendedores.index');
        Route::get('/emprendedores/create',         [EmprendedorController::class, 'create'])->name('emprendedores.create');
        Route::post('/emprendedores',               [EmprendedorController::class, 'store'])->name('emprendedores.store');
        Route::delete('/emprendedores/{emprendedor}', [EmprendedorController::class, 'destroy'])->name('emprendedores.destroy');
    });

    Route::middleware('rol:admin,emprendedor')->group(function () {
        Route::get('/emprendedores/{emprendedor}',       [EmprendedorController::class, 'show'])->name('emprendedores.show');
        Route::get('/emprendedores/{emprendedor}/edit',  [EmprendedorController::class, 'edit'])->name('emprendedores.edit');
        Route::put('/emprendedores/{emprendedor}',       [EmprendedorController::class, 'update'])->name('emprendedores.update');

        // Detalle del programa con sus emprendedores inscritos (req #7)
        Route::get('/programas/{programa}', [ProgramaFormacionController::class, 'show'])->name('programas.show');

        // Inscripción del emprendedor en programas. El controlador verifica que
        // el emprendedor autenticado solo opere sobre su propio registro.
        Route::post('/emprendedores/{emprendedor}/inscripciones', [InscripcionController::class, 'store'])
            ->name('inscripciones.store');
        Route::delete('/emprendedores/{emprendedor}/inscripciones/{programa}', [InscripcionController::class, 'destroy'])
            ->name('inscripciones.destroy');
    });
});
