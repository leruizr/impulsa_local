<?php

use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\ProgramaFormacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::resource('emprendedores', EmprendedorController::class);
Route::resource('programas', ProgramaFormacionController::class);
