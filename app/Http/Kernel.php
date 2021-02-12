<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Laravel\Jetstream\Http\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'institucionCorrespondiente' => \App\Http\Middleware\Instituciones\InstitucionCorrespondiente::class,
        'institucionYaCreada' => \App\Http\Middleware\Instituciones\InstitucionYaCreada::class,
        'soloInstituciones' => \App\Http\Middleware\Instituciones\SoloInstituciones::class,
        'cicloCorrespondiente' => \App\Http\Middleware\CiclosLectivos\CicloCorrespondiente::class,
        'soloInstitucionesDirectivos' => \App\Http\Middleware\CiclosLectivos\SoloInstitucionesDirectivos::class,
        'divisionCorrespondiente' => \App\Http\Middleware\Divisiones\DivisionCorrespondiente::class,
        'docenteYaCreado' => \App\Http\Middleware\Docentes\DocenteYaCreado::class,
        'soloInstitucionesDirectivosDocentes' => \App\Http\Middleware\Docentes\SoloInstitucionesDirectivosDocentes::class,
        'docenteCorrespondiente' => \App\Http\Middleware\Docentes\DocenteCorrespondiente::class,
        'asignaturaCorrespondiente' => \App\Http\Middleware\Asignaturas\AsignaturaCorrespondiente::class,
        'alumnoYaCreado' => \App\Http\Middleware\Alumnos\AlumnoYaCreado::class,
        'soloInstitucionesDirectivosAlumnos' => \App\Http\Middleware\Alumnos\SoloInstitucionesDirectivosAlumnos::class,
        'alumnoCorrespondiente' => \App\Http\Middleware\Alumnos\AlumnoCorrespondiente::class,
        'alumnoDivisionCorrespondiente' => \App\Http\Middleware\Alumnos\AlumnoDivisionCorrespondiente::class,
        'soloDocentes' => \App\Http\Middleware\Evaluaciones\SoloDocentes::class,
        'evaluacionCorrespondiente' => \App\Http\Middleware\Evaluaciones\EvaluacionCorrespondiente::class,
        'archivoCorrespondiente' => \App\Http\Middleware\Evaluaciones\ArchivoCorrespondiente::class,
        'comentarioEvaluacionCorrespondiente' => \App\Http\Middleware\Evaluaciones\ComentarioCorrespondiente::class,
        'verRespuestasEvaluacionCorrespondiente' => \App\Http\Middleware\Evaluaciones\VerRespuestasEvaluacionCorrespondiente::class,
        'respuestaEvaluacionCorrespondiente' => \App\Http\Middleware\Evaluaciones\RespuestaEvaluacionCorrespondiente::class,
        'entregaCorrespondiente' => \App\Http\Middleware\Evaluaciones\EntregaCorrespondiente::class,
        'soloAlumnos' => \App\Http\Middleware\Evaluaciones\SoloAlumnos::class,
        'entregaArchivoCorrespondiente' => \App\Http\Middleware\Evaluaciones\EntregaArchivoCorrespondiente::class,
        'correccionCorrespondiente' => \App\Http\Middleware\Evaluaciones\CorreccionCorrespondiente::class,
        'entregaComentarioCorrespondiente' => \App\Http\Middleware\Evaluaciones\EntregaComentarioCorrespondiente::class,
        'libretaCicloCorrespondiente' => \App\Http\Middleware\Libretas\LibretaCicloCorrespondiente::class,
        'libretaCorrespondiente' => \App\Http\Middleware\Libretas\LibretaCorrespondiente::class,
        'grupoCorrespondiente' => \App\Http\Middleware\Materiales\GrupoCorrespondiente::class,
        'materialCorrespondiente' => \App\Http\Middleware\Materiales\MaterialCorrespondiente::class,
        'publicacionCorrespondiente' => \App\Http\Middleware\Muro\PublicacionCorrespondiente::class,
        'verRespuestasMuroCorrespondiente' => \App\Http\Middleware\Muro\VerRespuestasMuroCorrespondiente::class,
        'respuestaMuroCorrespondiente' => \App\Http\Middleware\Muro\RespuestaMuroCorrespondiente::class,
        'verArchivosMuroCorrespondiente' => \App\Http\Middleware\Muro\VerArchivosMuroCorrespondiente::class,
        'archivoMuroCorrespondiente' => \App\Http\Middleware\Muro\ArchivoMuroCorrespondiente::class,
        'directivoYaCreado' => \App\Http\Middleware\Directivos\DirectivoYaCreado::class,
        'directivoCorrespondiente' => \App\Http\Middleware\Directivos\DirectivoCorrespondiente::class,
        'padreYaCreado' => \App\Http\Middleware\Padres\PadreYaCreado::class,
        'soloInstitucionesDirectivosPadres' => \App\Http\Middleware\Padres\SoloInstitucionesDirectivosPadres::class,
        'padreCorrespondiente' => \App\Http\Middleware\Padres\PadreCorrespondiente::class,
        'repetidorCorrespondiente' => \App\Http\Middleware\Repetidores\RepetidorCorrespondiente::class,
        'verificarExAlumnoNuevo' => \App\Http\Middleware\ExAlumnos\VerificarExAlumnoNuevo::class,
        'exAlumnoCorrespondiente' => \App\Http\Middleware\ExAlumnos\ExAlumnoCorrespondiente::class,
        'asignaturaAdeudadaCorrespondiente' => \App\Http\Middleware\Asignaturas\AsignaturaAdeudadaCorrespondiente::class,
        'grupoAdeudadoCorrespondiente' => \App\Http\Middleware\Materiales\GrupoAdeudadoCorrespondiente::class,
        'deudaCorrespondiente' => \App\Http\Middleware\Deudores\DeudaCorrespondiente::class,
        'mesaCorrespondiente' => \App\Http\Middleware\Deudores\MesaCorrespondiente::class,
        'inscripcionCorrespondiente' => \App\Http\Middleware\Deudores\InscripcionCorrespondiente::class,
        'verificarInscripcion' => \App\Http\Middleware\Deudores\VerificarInscripcion::class,
        'rendirEntregaCorrespondiente' => \App\Http\Middleware\Deudores\RendirEntregaCorrespondiente::class,
        'rendirCorreccionCorrespondiente' => \App\Http\Middleware\Deudores\RendirCorreccionCorrespondiente::class,
        'rendirComentarioCorrespondiente' => \App\Http\Middleware\Deudores\RendirComentarioCorrespondiente::class,
        'mesaArchivoCorrespondiente' => \App\Http\Middleware\Deudores\MesaArchivoCorrespondiente::class,
        'prohibidoInstituciones' => \App\Http\Middleware\Instituciones\ProhibidoInstituciones::class,
    ];
}
