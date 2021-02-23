<?php

namespace App\Http\Middleware\Asignaturas;

use App\Services\Asignaturas\VerificarAsignatura;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class AsignaturaCorrespondiente
{
    protected $ruta;
    protected $asignaturaService;

    public function __construct(
        RutaService $ruta,
        VerificarAsignatura $asignaturaService,
    )

    {
        $this->ruta = $ruta;
        $this->asignaturaService = $asignaturaService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($link[8])) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de esta asignatura.');
        }

        if (session('tipo') == 'Directivo' || session('tipo') == 'Institucion') {

            if ($this->asignaturaService->verificarInstitucionDirectivo($link[8])) {
                return $next($request);
            }
            abort(403, 'Esta asignatura no forma parte de tu institución.');
        }
        abort(403, 'No puede estar aquí.');
    }
}
