<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Entrega;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class EntregaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $entrega = Entrega::find($link[10]);

        if (session('tipo') == 'Docente') {
            $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $entrega->evaluacion->asignatura_id)->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->docente_id == session('tipo_id')) {
                    return $next($request);
                }
            }
            abort(403, 'Esta entrega de una evaluacion no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Alumno') {
            if ($entrega->alumno_id == session('tipo_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no es tuya.');
        }

        if (session('tipo') == 'Padre') {
            if ($entrega->alumno_id == session('alumno_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no es de tu hijo.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($entrega->evaluacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no forma parte de tu institucion.');
        }

        abort(403, 'No puedes estar aqui.');
    }
}
