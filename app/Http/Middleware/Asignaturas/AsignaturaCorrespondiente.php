<?php

namespace App\Http\Middleware\Asignaturas;

use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class AsignaturaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (session('tipo') == 'Docente') {
            if (AsignaturaDocente::where('asignatura_id', $link[8])->where('docente_id', session('tipo_id'))->exists()) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de esta asignatura.');
        }

        if (session('tipo') == 'Directivo' || session('tipo') == 'Institucion') {
            
            $asignatura = Asignatura::find($link[8]);
            
            if ($asignatura->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta asignatura no forma parte de la institución de la que formas parte.');
        }
        abort(403, 'No puede estar aquí.');
    }
}
