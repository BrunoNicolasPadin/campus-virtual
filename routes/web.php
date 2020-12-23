<?php

use App\Http\Controllers\CiclosLectivos\CicloLectivoController;
use App\Http\Controllers\Estructuras\EstructuraController;
use App\Http\Controllers\Instituciones\BuscadorDeInstitucionesController;
use App\Http\Controllers\Instituciones\InstitucionController;
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
    Route::resource('divisiones', EstructuraController::class);
});