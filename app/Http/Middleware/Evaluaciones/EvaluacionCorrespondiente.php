<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class EvaluacionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $evaluacion = Evaluacion::find($link[8]);

        if (session('tipo') == 'Docente') {
            $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $evaluacion->asignatura_id)->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->docente_id == session('tipo_id')) {
                    return $next($request);
                }
            }
            abort(403, 'Esta evaluacion no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($evaluacion->division_id == session('division_id')) {
                return $next($request);
            }
            abort(403, 'Esta evaluacion no forma parte de tu division.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($evaluacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta evaluacion no forma parte de la institucion de la que perteneces.');
        }

        abort(403, 'No puedes estar aqui.');
    }
}
