<?php

use App\Http\Controllers\Asignaturas\AsignaturaController;
use App\Http\Controllers\Asignaturas\AsignaturaDocenteController;
use App\Http\Controllers\Asignaturas\AsignaturaHorarioController;
use App\Http\Controllers\Asignaturas\HorarioController;
use App\Http\Controllers\CiclosLectivos\CicloLectivoController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Estructuras\EstructuraController;
use App\Http\Controllers\Evaluaciones\CorreccionController;
use App\Http\Controllers\Evaluaciones\EntregaArchivoController;
use App\Http\Controllers\Evaluaciones\EntregaComentarioController;
use App\Http\Controllers\Evaluaciones\EntregaController;
use App\Http\Controllers\Evaluaciones\EvaluacionArchivoController;
use App\Http\Controllers\Evaluaciones\EvaluacionComentarioController;
use App\Http\Controllers\Evaluaciones\EvaluacionController;
use App\Http\Controllers\Evaluaciones\EvaluacionRespuestaController;
use App\Http\Controllers\Instituciones\BuscadorDeInstitucionesController;
use App\Http\Controllers\Instituciones\InstitucionController;
use App\Http\Controllers\Libretas\LibretaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Materiales\GrupoController;
use App\Http\Controllers\Materiales\MaterialController;
use App\Http\Controllers\Muro\MuroArchivoController;
use App\Http\Controllers\Muro\MuroController;
use App\Http\Controllers\Muro\MuroRespuestaController;
use App\Http\Controllers\Roles\ActivarCuentaController;
use App\Http\Controllers\Roles\AlumnoController;
use App\Http\Controllers\Roles\DirectivoController;
use App\Http\Controllers\Roles\DocenteController;
use App\Http\Controllers\Roles\PadreController;
use App\Http\Controllers\Roles\RolController;
use App\Http\Controllers\Roles\TipoCuentaController;
use App\Http\Controllers\RolesDivision\AlumnoDivisionController;
use App\Http\Controllers\RolesDivision\DocenteDivisionController;
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
})->name('inicio');

Route::post('/login', [LoginController::class, 'authenticate'])->name('loginNuevo');

Route::get('/dashboard', [DashboardController::class, 'mostrarDashboard'])->name('dashboard');

Route::get('tipos-de-cuentas', [TipoCuentaController::class, 'mostrarCuentas'])->name('roles.mostrarCuentas');
Route::get('activar-docente/{id}', [ActivarCuentaController::class, 'activarDocente'])->name('roles.activarDocente');
Route::get('activar-directivo/{id}', [ActivarCuentaController::class, 'activarDirectivo'])->name('roles.activarDirectivo');
Route::get('activar-padre/{id}', [ActivarCuentaController::class, 'activarPadre'])->name('roles.activarPadre');

Route::get('buscador-de-instituciones', [BuscadorDeInstitucionesController::class, 'buscar'])->name('buscador-de-instituciones');
Route::resource('instituciones', InstitucionController::class);
Route::prefix('instituciones/{institucion_id}')->group(function () {
    
    Route::resource('ciclos-lectivos', CicloLectivoController::class);
    Route::get('anotarse', [RolController::class, 'anotarse'])->name('roles.anotarse');
    Route::resource('roles', RolController::class);
    Route::resource('directivos', DirectivoController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('padres', PadreController::class);
    Route::get('verificar-clave', [PadreController::class, 'verificarClave'])->name('padres.verificarClave');
    Route::prefix('alumnos/{alumno_id}')->group(function () {
            
        Route::resource('libretas', LibretaController::class);
    });

    Route::resource('divisiones', EstructuraController::class);
    Route::prefix('divisiones/{division_id}')->group(function () {
        
        Route::resource('asignaturas', AsignaturaController::class);
        Route::prefix('asignaturas/{asignatura_id}')->group(function () {
            
            Route::resource('asignaturas-docentes', AsignaturaDocenteController::class);
            Route::resource('asignaturas-horarios', AsignaturaHorarioController::class);
        });

        Route::get('horarios', [HorarioController::class, 'mostrarHorarios'])->name('horarios.mostrar');

        Route::get('alumnos', [AlumnoDivisionController::class, 'mostrarAlumnos'])->name('alumnosDivision.mostrar');
        Route::get('{alumno_id}/sacarlo', [AlumnoDivisionController::class, 'sacarloDeLaDivision'])->name('alumnosDivision.sacarlo');

        Route::get('docentes', [DocenteDivisionController::class, 'mostrarDocentes'])->name('docentesDivision.mostrar');

        Route::resource('evaluaciones', EvaluacionController::class);
        Route::prefix('evaluaciones/{evaluacion_id}')->group(function () {
        
            Route::resource('evaluaciones-archivos', EvaluacionArchivoController::class);
            Route::resource('entregas', EntregaController::class);
            Route::prefix('entregas/{entrega_id}')->group(function () {
        
                Route::resource('entregas-archivos', EntregaArchivoController::class);
                Route::resource('correcciones', CorreccionController::class);
                Route::resource('entregas-comentarios', EntregaComentarioController::class);
            });

            Route::resource('evaluaciones-comentarios', EvaluacionComentarioController::class);
            Route::prefix('evaluaciones-comentarios/{comentario_id}')->group(function () {
                Route::resource('evaluaciones-respuestas', EvaluacionRespuestaController::class);
            });
        });

        Route::resource('materiales', GrupoController::class);
        Route::prefix('materiales/{grupo_id}')->group(function () {
        
            Route::resource('materiales-archivos', MaterialController::class);
            
        });

        Route::resource('muro', MuroController::class);
        Route::prefix('muro/{publicacion_id}')->group(function () {
        
            Route::resource('muro-archivos', MuroArchivoController::class);
            Route::resource('muro-respuestas', MuroRespuestaController::class);
        });
    });
});