<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\Anotado;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class InscripcionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $anotado = Anotado::findOrFail($link[12]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' ) {
            if (session('institucion_id') == $anotado->alumno->institucion_id) {
                return $next($request);
            }
            abort(403, 'Esta inscripcion es de un alumno que no forma parte de tu institucion.');
        }

        if (session('tipo') == 'Docente') {
            if (AsignaturaDocente::where('asignatura_id', $anotado->mesa->asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura en la que se inscribio este alumno.');
        }

        if (session('tipo') == 'Alumno' ) {
            
            if (session('tipo_id') == $anotado->alumno_id) {
                return $next($request);
            }
            abort(403, 'Esta no es tu inscripcion.');
        }

        if (session('tipo') == 'Padre' ) {
            if (session('alumno_id') == $anotado->alumno_id) {
                return $next($request);
            }
            abort(403, 'Esta no es la inscripcion de su hijo/a.');
        }

        abort(403, 'No puede estar aqui.');
    }
}
