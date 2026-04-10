<?php

// Importación de los controladores usados en las rutas
use App\Http\Controllers\EmprendedorController;
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
// GET    /emprendedores/{id}/edit -> edit    (formulario de edición)
// PUT    /emprendedores/{id}      -> update  (actualiza)
// DELETE /emprendedores/{id}      -> destroy (elimina)
Route::resource('emprendedores', EmprendedorController::class);

// Rutas del recurso Programas de Formación (solo index, create y store por ahora)
Route::resource('programas', ProgramaFormacionController::class);
