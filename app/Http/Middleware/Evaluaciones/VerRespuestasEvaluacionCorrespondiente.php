<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class VerRespuestasEvaluacionCorrespondiente
{
    protected $ruta;
    protected $docenteService;

    public function __construct(
        RutaService $ruta, 
        DocenteService $docenteService
    )

    {
        $this->ruta = $ruta;
        $this->docenteService = $docenteService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $comentario = EvaluacionComentario::findOrFail($link[10]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($comentario->evaluacion->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'No puedes ver las respuestas de comentarios hechos en evaluaciones que no son de las asignaturas que eres docente.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($comentario->evaluacion->division_id == session('division_id')) {
                return $next($request);
            }
            abort(403, 'No puedes ver estas respuestas.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($comentario->evaluacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Estas respuestas no forma parte de tu institución.');
        }

        abort(403, 'No puedes estar aquí.');
    }
}
