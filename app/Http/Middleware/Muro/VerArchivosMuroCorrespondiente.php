<?php

namespace App\Http\Middleware\Muro;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Muro\Muro;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class VerArchivosMuroCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $publicacion = Muro::find($link[8]);

        if (session('tipo') == 'Docente') {
            $asignaturasDocentes = AsignaturaDocente::where('docente_id', session('tipo_id'))->get();

            foreach ($asignaturasDocentes as $asignaturaDocente) {
                if ($asignaturaDocente->asignatura->division_id == $publicacion->division_id) {
                    return $next($request);
                }
            }
            abort(403, 'No puedes ver los archivos de publicaciones hechas en divisiones en las que no eres docente.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($publicacion->division_id == session('division_id')) {
                return $next($request);
            }
            abort(403, 'No puedes ver los archivos de una publicación hecha en una división de la que no formas parte.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($publicacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Estos archivos no forma parte de tu institución.');
        }

        abort(403, 'No puedes estar aquí.');
    }
}
