<?php

namespace App\Http\Middleware\Libretas;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Libretas\Libreta;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class LibretaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $libreta = Libreta::find($link[8]);

        if ($libreta->cicloLectivo->institucion_id == session('institucion_id')) {
            
            if (session('tipo') == 'Docente') {
                $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $libreta->asignatura_id)->get();

                foreach ($asignaturasDocentes as $asignaturaDocente) {
                    if ($asignaturaDocente->docente_id == session('tipo_id')) {
                        return $next($request);
                    }
                }
                abort(403, 'Esta asignatura no eres docente.');
            }
            return $next($request);
        }
        abort(403, 'Esta libreta no es de tu institucion.');
    }
}
