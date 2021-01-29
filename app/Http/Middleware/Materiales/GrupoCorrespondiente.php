<?php

namespace App\Http\Middleware\Materiales;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Materiales\Grupo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class GrupoCorrespondiente
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

        if (session('tipo') == 'Docente') {
            if (AsignaturaDocente::where('asignatura_id', $grupo->asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
                return $next($request);
            }
            abort(403, 'Este grupo de archivos no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($grupo->division_id == session('division_id')) {
                return $next($request);
            }
            abort(403, 'Este grupo no forma parte de tu division.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($grupo->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este grupo no forma parte de la institucion de la que perteneces.');
        }

        abort(403, 'No puedes estar aqui.');
    }
}
