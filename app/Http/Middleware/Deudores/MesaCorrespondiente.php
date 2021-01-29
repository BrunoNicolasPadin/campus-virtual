<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Deudores\Mesa;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class MesaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $mesa = Mesa::findOrFail($link[10]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' ) {
            if (session('institucion_id') == $mesa->asignatura->division->institucion_id) {
                return $next($request);
            }
            abort(403, 'Esta asignatura adeudada no es de tu institucion.');
        }

        if (session('tipo') == 'Docente') {
            if (AsignaturaDocente::where('asignatura_id', $mesa->asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura a la que pertenece la mesa.');
        }

        if (session('tipo') == 'Alumno' ) {
            
            if (AlumnoDeudor::where('alumno_id', session('tipo_id'))->where('asignatura_id', $mesa->asignatura_id)
                ->where('aprobado', '0')
                ->exists()) {
                return $next($request);
            }
            abort(403, 'No adeuda esta asignatura (O se confundio o ya la tiene aprobada y por la tanto no puede acceder.');
        }

        if (session('tipo') == 'Padre' ) {
            if (AlumnoDeudor::where('alumno_id', session('alumno_id'))->where('asignatura_id', $mesa->asignatura_id)
                ->where('aprobado', '0')
                ->exists()) {
                return $next($request);
            }
            abort(403, 'Si hijo/a adeuda esta asignatura (O se confundio o ya la tiene aprobada y por la tanto no puede acceder.');
        }

        abort(403, 'No puede estar aqui.');
    }
}
