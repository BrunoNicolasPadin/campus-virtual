<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Correccion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class CorreccionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $correccion = Correccion::find($link[12]);

        if (session('tipo') == 'Docente') {
            $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $correccion->entrega->evaluacion->asignatura_id)->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->docente_id == session('tipo_id')) {
                    return $next($request);
                }
            }
            abort(403, 'Esta entrega de una evaluacion no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($correccion->entrega->evaluacion->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta correccion no forma parte de tu institucion');
        }

        abort(403, 'No puedes estar aqui.');
    }
}
