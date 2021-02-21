<?php
use App\Http\Controllers\Alumnos\AlumnoEstadisticaController;
use App\Http\Controllers\Asignaturas\AsignaturaController;
use App\Http\Controllers\Asignaturas\AsignaturaDeudorController;
use App\Http\Controllers\Asignaturas\AsignaturaDocenteController;
use App\Http\Controllers\Asignaturas\AsignaturaEstadisticaController;
use App\Http\Controllers\Asignaturas\AsignaturaHorarioController;
use App\Http\Controllers\Asignaturas\HorarioController;
use App\Http\Controllers\Calendario\CalendarioController;
use App\Http\Controllers\CiclosLectivos\CicloLectivoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Deudores\AlumnoDeudorController;
use App\Http\Controllers\Deudores\AnotadoController;
use App\Http\Controllers\Deudores\MesaArchivoController;
use App\Http\Controllers\Deudores\MesaController;
use App\Http\Controllers\Deudores\RendirComentarioController;
use App\Http\Controllers\Deudores\RendirCorreccionController;
use App\Http\Controllers\Deudores\RendirEntregaController;
use App\Http\Controllers\Estructuras\EstructuraController;
use App\Http\Controllers\Estructuras\EstructuraEstadisticaController;
use App\Http\Controllers\Estructuras\FormaDescripcionController;
use App\Http\Controllers\Estructuras\FormaEvaluacionController;
use App\Http\Controllers\Estructuras\LimpiarDivisionController;
use App\Http\Controllers\Evaluaciones\CorreccionController;
use App\Http\Controllers\Evaluaciones\EntregaArchivoController;
use App\Http\Controllers\Evaluaciones\EntregaComentarioController;
use App\Http\Controllers\Evaluaciones\EntregaController;
use App\Http\Controllers\Evaluaciones\EvaluacionArchivoController;
use App\Http\Controllers\Evaluaciones\EvaluacionComentarioController;
use App\Http\Controllers\Evaluaciones\EvaluacionController;
use App\Http\Controllers\Evaluaciones\EvaluacionEstadisticaController;
use App\Http\Controllers\Evaluaciones\EvaluacionRespuestaController;
use App\Http\Controllers\ExAlumnos\ExAlumnoController;
use App\Http\Controllers\ExAlumnos\ExAlumnoEstadisticaController;
use App\Http\Controllers\Instituciones\BuscadorDeInstitucionesController;
use App\Http\Controllers\Instituciones\InstitucionController;
use App\Http\Controllers\Libretas\ExportarLibretaController;
use App\Http\Controllers\Libretas\LibretaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Materiales\BuscarGruposController;
use App\Http\Controllers\Materiales\GrupoController;
use App\Http\Controllers\Materiales\MaterialController;
use App\Http\Controllers\Muro\MuroArchivoController;
use App\Http\Controllers\Muro\MuroController;
use App\Http\Controllers\Muro\MuroRespuestaController;
use App\Http\Controllers\Repitentes\RepitenteController;
use App\Http\Controllers\Repitentes\RepitenteDivisionController;
use App\Http\Controllers\Repitentes\RepitenteEstadisticaController;
use App\Http\Controllers\Roles\ActivarCuentaController;
use App\Http\Controllers\Roles\AlumnoController;
use App\Http\Controllers\Roles\DirectivoController;
use App\Http\Controllers\Roles\DocenteController;
use App\Http\Controllers\Roles\PadreController;
use App\Http\Controllers\Roles\RolController;
use App\Http\Controllers\Roles\TipoCuentaController;
use App\Http\Controllers\RolesDivision\AlumnoDivisionController;
use App\Http\Controllers\RolesDivision\DocenteDivisionController;
use App\Http\Controllers\TopNavController;
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

Route::post('/enviar-email', [ContactoController::class, 'enviarEmail'])->name('contacto.enviarEmail');

Route::post('/login', [LoginController::class, 'authenticate'])->name('loginNuevo');

Route::inertia('detalles', 'Suscripciones/Detalles')->name('suscripciones.detalles');

Route::get('/dashboard', [DashboardController::class, 'mostrarDashboard'])->name('dashboard');

Route::get('/top-divisiones', [TopNavController::class, 'mostrarDivisiones'])->name('topNav.divisiones');
Route::get('top-calendario', [TopNavController::class, 'mostrarCalendario'])->name('topNav.calendario');
Route::get('/top-ciclos-lectivos', [TopNavController::class, 'mostrarCiclosLectivos'])->name('topNav.ciclos-lectivos');
Route::get('/top-roles', [TopNavController::class, 'mostrarRoles'])->name('topNav.roles');
Route::get('/top-institucion', [TopNavController::class, 'mostrarPerfilInstitucional'])->name('topNav.institucion');

Route::get('tipos-de-cuentas', [TipoCuentaController::class, 'mostrarCuentas'])->name('roles.mostrarCuentas');
Route::get('activar-docente/{id}', [ActivarCuentaController::class, 'activarDocente'])->name('roles.activarDocente');
Route::get('activar-alumno/{id}', [ActivarCuentaController::class, 'activarAlumno'])->name('roles.activarAlumno');
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
    
    Route::get('verificar-clave-institucion', [AlumnoController::class, 'verificarClave'])->name('alumnos.verificarClaveInstitucion');
    Route::resource('padres', PadreController::class);
    Route::get('verificar-clave', [PadreController::class, 'verificarClave'])->name('padres.verificarClave');
    Route::prefix('alumnos/{alumno_id}')->group(function () {
            
        Route::resource('libretas', LibretaController::class);
        Route::get('libretas/exportar/{ciclo_lectivo_id}', [ExportarLibretaController::class, 'exportarLibreta'])->name('libretas.exportarUna');

        Route::resource('asignaturas-adeudadas', AlumnoDeudorController::class);
        Route::get('asignaturas-adeudadas/{division_id}/create', [AlumnoDeudorController::class, 'createAsignatura'])->name('asignaturas-adeudadas.createAsignatura');

        Route::get('estadisticas', [AlumnoEstadisticaController::class, 'mostrarCiclosLectivos'])->name('alumnos.mostrarCiclosLectivos');
        Route::get('estadisticas/{ciclo_lectivo_id}', [AlumnoEstadisticaController::class, 'mostrarEstadisticas'])->name('alumnos.mostrarEstadisticas');
    });

    Route::resource('formas-evaluacion', FormaEvaluacionController::class);
    Route::prefix('formas-evaluacion/{forma_evaluacion_id}')->group(function () {
        
        Route::resource('formas-descripcion', FormaDescripcionController::class);
    });

    Route::resource('divisiones', EstructuraController::class);
    Route::prefix('divisiones/{division_id}')->group(function () {
        
        Route::resource('asignaturas', AsignaturaController::class);
        Route::prefix('asignaturas/{asignatura_id}')->group(function () {
            
            Route::resource('asignaturas-docentes', AsignaturaDocenteController::class);
            Route::resource('asignaturas-horarios', AsignaturaHorarioController::class);
            Route::resource('mesas', MesaController::class);
            Route::prefix('mesas/{mesa_id}')->group(function () {
                
                Route::resource('mesas-archivos', MesaArchivoController::class);
                Route::resource('anotados', AnotadoController::class);
                Route::prefix('anotados/{anotado_id}')->group(function () {
                
                    Route::resource('rendir-entregas', RendirEntregaController::class);
                    Route::resource('rendir-correcciones', RendirCorreccionController::class);
                    Route::resource('rendir-comentarios', RendirComentarioController::class);
                });
            });
            Route::get('deudores', [AsignaturaDeudorController::class, 'mostrarDeudores'])->name('asignaturas.deudores');
            Route::post('deudores/filtrados', [AsignaturaDeudorController::class, 'filtrarDeudores'])->name('asignaturas.deudores-filtrados');

            Route::get('estadisticas', [AsignaturaEstadisticaController::class, 'mostrarEstadisticas'])->name('asignaturas.estadisticas');
            Route::get('estadisticas/{ciclo_lectivo_id}', [AsignaturaEstadisticaController::class, 'mostrarPromedios'])->name('asignaturas.mostrarPromedios');
        });

        Route::get('horarios', [HorarioController::class, 'mostrarHorarios'])->name('horarios.mostrar');

        Route::get('alumnos', [AlumnoDivisionController::class, 'mostrarAlumnos'])->name('alumnosDivision.mostrar');
        Route::get('{alumno_id}/sacarlo', [AlumnoDivisionController::class, 'sacarloDeLaDivision'])->name('alumnosDivision.sacarlo');
        Route::get('alumnos/hacerlos-pasar', [AlumnoDivisionController::class, 'hacerlosPasar'])->name('alumnosDivision.hacerlosPasar');
        Route::post('alumnos/cambiarCurso', [AlumnoDivisionController::class, 'cambiarCurso'])->name('alumnosDivision.cambiarCurso');

        Route::get('docentes', [DocenteDivisionController::class, 'mostrarDocentes'])->name('docentesDivision.mostrar');

        Route::resource('evaluaciones', EvaluacionController::class);
        Route::prefix('evaluaciones/{evaluacion_id}')->group(function () {
        
            Route::get('estadisticas', [EvaluacionEstadisticaController::class, 'mostrarEstadisticas'])->name('evaluaciones.estadisticas');
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
        Route::post('materiales/filtrar', [BuscarGruposController::class, 'filtrarPorAsignaturas'])->name('materiales.filtrarPorAsignatura');
        Route::prefix('materiales/{grupo_id}')->group(function () {
        
            Route::resource('materiales-archivos', MaterialController::class);
        });

        Route::resource('muro', MuroController::class);
        Route::prefix('muro/{publicacion_id}')->group(function () {
        
            Route::resource('muro-archivos', MuroArchivoController::class);
            Route::resource('muro-respuestas', MuroRespuestaController::class);
        });

        Route::get('repitentes', [RepitenteDivisionController::class, 'mostrar'])->name('repitentes-division.mostrar');
        Route::post('repitentes/filtrados', [RepitenteDivisionController::class, 'filtrarRepitentes'])->name('repitentes-division.filtrar');

        Route::get('estadisticas', [EstructuraEstadisticaController::class, 'mostrarCiclosLectivos'])->name('divisiones.mostrarCiclosLectivos');
        Route::get('estadisticas/{ciclo_lectivo_id}', [EstructuraEstadisticaController::class, 'mostrarEstadisticas'])->name('divisiones.mostrarEstadisticas');
   
        Route::get('limpiar', [LimpiarDivisionController::class, 'limpiarDivision'])->name('divisiones.limpiar');
    });

    Route::resource('repitentes', RepitenteController::class);
    Route::get('repitentes/{alumno_id}/create', [RepitenteController::class, 'createRepitente'])->name('repitentes.createRepitente');
    Route::post('repitentes/filtrados', [RepitenteController::class, 'filtrarRepitentes'])->name('repitentes.filtrar');
    Route::get('repitentes-estadisticas', [RepitenteEstadisticaController::class, 'mostrarEstadisticas'])->name('repitentes.estadisticas');

    Route::resource('exalumnos', ExAlumnoController::class);
    Route::post('exalumnos/filtrados', [ExAlumnoController::class, 'filtrarExAlumnos'])->name('exalumnos.filtrar');
    Route::get('exalumnos/{alumno_id}/create', [ExAlumnoController::class, 'createExAlumno'])->name('exalumnos.createExAlumno');
    Route::get('exalumnos-estadisticas', [ExAlumnoEstadisticaController::class, 'mostrarEstadisticas'])->name('exalumnos.estadisticas');

    Route::get('calendario/{year}', [CalendarioController::class, 'mostrarCalendario'])->name('calendario.mostrar');
});

Route::inertia('/tutoriales', 'Tutoriales/Principal')->name('tutoriales');
Route::prefix('tutoriales')->group(function () {

    Route::inertia('institucion', 'Tutoriales/Institucion')->name('tutoriales.institucion');
    Route::inertia('ciclo-lectivo', 'Tutoriales/CicloLectivo')->name('tutoriales.ciclo-lectivo');
    Route::inertia('estructura', 'Tutoriales/Estructura')->name('tutoriales.estructura');
    Route::inertia('asignatura', 'Tutoriales/Asignatura')->name('tutoriales.asignatura');
    Route::inertia('usuario', 'Tutoriales/PerfilUsuario')->name('tutoriales.usuario');
    Route::inertia('directivo', 'Tutoriales/Directivo')->name('tutoriales.directivo');
    Route::inertia('docente', 'Tutoriales/Docente')->name('tutoriales.docente');
    Route::inertia('alumno', 'Tutoriales/Alumno')->name('tutoriales.alumno');
    Route::inertia('padre', 'Tutoriales/Padre')->name('tutoriales.padre');
    Route::inertia('evaluacion', 'Tutoriales/Evaluacion')->name('tutoriales.evaluacion');
    Route::inertia('correccion', 'Tutoriales/Correccion')->name('tutoriales.correccion');
    Route::inertia('entrega', 'Tutoriales/Entrega')->name('tutoriales.entrega');
    Route::inertia('material', 'Tutoriales/Material')->name('tutoriales.material');
    Route::inertia('libreta', 'Tutoriales/Libreta')->name('tutoriales.libreta');
    Route::inertia('muro', 'Tutoriales/Muro')->name('tutoriales.muro');
    Route::inertia('mesa', 'Tutoriales/Mesa')->name('tutoriales.mesa');
    Route::inertia('estadistica', 'Tutoriales/Estadistica')->name('tutoriales.estadistica');
    Route::inertia('repitente', 'Tutoriales/Repitente')->name('tutoriales.repitente');
    Route::inertia('exalumno', 'Tutoriales/ExAlumno')->name('tutoriales.exalumno');
    Route::inertia('calendario', 'Tutoriales/Calendario')->name('tutoriales.calendario');
    Route::inertia('como-empezar', 'Tutoriales/ComoEmpezar')->name('tutoriales.como-empezar');
    Route::inertia('nueveo-ciclo-lectivo', 'Tutoriales/NuevoCicloLectivo')->name('tutoriales.nuevo-ciclo-lectivo');
});