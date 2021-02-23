<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class EvaluacionCorrespondiente
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

        $evaluacion = Evaluacion::findOrFail($link[8]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($evaluacion->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Esta evaluación no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($evaluacion->division_id == session('division_id')) {
                return $next($request);
            }
            abort(403, 'Esta evaluación no forma parte de tu división.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($evaluacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta evaluación no forma parte de tu institución.');
        }

        abort(403, 'No puedes estar aqui.');
    }
}
