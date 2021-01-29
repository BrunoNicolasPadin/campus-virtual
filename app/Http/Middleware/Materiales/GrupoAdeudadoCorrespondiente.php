<?php

namespace App\Http\Middleware\Materiales;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Materiales\Grupo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class GrupoAdeudadoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $grupo = Grupo::find($link[8]);

        if (session('tipo') == 'Alumno') {
            if (AlumnoDeudor::where('id', session('tipo_id'))->where('asignatura_id', $grupo->asignatura_id)->exists()) {
                return $next($request);
            }
            abort(403, 'Usted no adeuda esta asignatura.');
        }

        if (session('tipo') == 'Padre') {
            if (AlumnoDeudor::where('id', session('alumno_id'))->where('asignatura_id', $grupo->asignatura_id)->exists()) {
                return $next($request);
            }
            abort(403, 'Su hijo/a no adeuda esta asignatura.');
        }

        if (session('tipo') == 'Docente') {
            if (AsignaturaDocente::where('asignatura_id', $grupo->asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de esta asignatura.');
        }

        if (session('tipo') == 'Directivo' || session('tipo') == 'Institucion') {
            if ($grupo->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este grupo de archivos no forma parte de la institucion de la que formas parte.');
        }
        abort(403, 'No puede estar aqui.');
    }
}
