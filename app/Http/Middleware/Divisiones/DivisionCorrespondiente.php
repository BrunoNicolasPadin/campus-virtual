<?php

namespace App\Http\Middleware\Divisiones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class DivisionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $division = Division::find($link[6]);

        if (session('tipo') == 'Docente') {
            $asignaturasDocentes = AsignaturaDocente::where('docente_id', session('tipo_id'))->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->asignatura->division_id == $division->id) {
                    return $next($request);
                }
            }
            abort(403, 'No eres docente de ninguna asignatura de esta división.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($division->id == session('division_id')) {
                return $next($request);
            }
            abort(403, 'No formas parte de esta división.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta división no forma parte de tu institución.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
