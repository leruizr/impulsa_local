<?php

// Importación de los controladores usados en las rutas
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ProgramaFormacionController;
use Illuminate\Support\Facades\Route;

// Ruta de la página de inicio (bienvenida)
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Rutas del recurso Emprendedores (CRUD completo):
// GET    /emprendedores           -> index   (lista todos)
// GET    /emprendedores/create    -> create  (formulario de creación)
// POST   /emprendedores           -> store   (guarda nuevo)
// GET    /emprendedores/{id}      -> show    (detalle con programas inscritos)
// GET    /emprendedores/{id}/edit -> edit    (formulario de edición)
// PUT    /emprendedores/{id}      -> update  (actualiza)
// DELETE /emprendedores/{id}      -> destroy (elimina)
Route::resource('emprendedores', EmprendedorController::class);

// Rutas del recurso Programas de Formación (CRUD completo)
Route::resource('programas', ProgramaFormacionController::class);

// Rutas para la inscripción de emprendedores en programas de formación.
// Trabajan sobre la tabla pivote 'emprendedor_programa'.
// POST   /emprendedores/{emprendedor}/inscripciones            -> store   (inscribe al emprendedor en un programa)
// DELETE /emprendedores/{emprendedor}/inscripciones/{programa} -> destroy (cancela la inscripción)
Route::post('/emprendedores/{emprendedor}/inscripciones', [InscripcionController::class, 'store'])
    ->name('inscripciones.store');
Route::delete('/emprendedores/{emprendedor}/inscripciones/{programa}', [InscripcionController::class, 'destroy'])
    ->name('inscripciones.destroy');
