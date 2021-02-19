<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Archivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class ArchivoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $archivo = Archivo::find($link[10]);

        if (session('tipo') == 'Docente') {

            $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $archivo->evaluacion->asignatura_id)->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->docente_id == session('tipo_id')) {
                    return $next($request);
                }
            }
            abort(403, 'Este archivo no forma parte de una evaluación tuya.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($archivo->evaluacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este archivo no forman parte de tu institución.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
