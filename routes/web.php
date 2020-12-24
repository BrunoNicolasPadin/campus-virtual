<?php

use App\Http\Controllers\Asignaturas\AsignaturaController;
use App\Http\Controllers\Asignaturas\AsignaturaDocenteController;
use App\Http\Controllers\Asignaturas\AsignaturaHorarioController;
use App\Http\Controllers\CiclosLectivos\CicloLectivoController;
use App\Http\Controllers\Estructuras\EstructuraController;
use App\Http\Controllers\Instituciones\BuscadorDeInstitucionesController;
use App\Http\Controllers\Instituciones\InstitucionController;
use App\Http\Controllers\Roles\DocenteController;
use App\Http\Controllers\Roles\RolController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::get('buscador-de-instituciones', [BuscadorDeInstitucionesController::class, 'buscar'])->name('buscador-de-instituciones');
Route::resource('instituciones', InstitucionController::class);
Route::prefix('instituciones/{institucion_id}')->group(function () {
    
    Route::resource('ciclos-lectivos', CicloLectivoController::class);
    Route::get('anotarse', [RolController::class, 'anotarse'])->name('roles.anotarse');
    Route::resource('roles', RolController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('divisiones', EstructuraController::class);
    Route::prefix('divisiones/{division_id}')->group(function () {
        
        Route::resource('asignaturas', AsignaturaController::class);
        Route::prefix('asignaturas/{asignatura_id}')->group(function () {
            
            Route::resource('asignaturas-docentes', AsignaturaDocenteController::class);
            Route::resource('asignaturas-horarios', AsignaturaHorarioController::class);
        });
        
    });
});