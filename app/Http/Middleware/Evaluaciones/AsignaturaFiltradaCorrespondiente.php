<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Services\Asignaturas\VerificarAsignatura;
use App\Services\Mesas\DeudorService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class AsignaturaFiltradaCorrespondiente
{
    protected $ruta;
    protected $asignaturaService;
    protected $deudorService;

    public function __construct(
        RutaService $ruta,
        VerificarAsignatura $asignaturaService,
        DeudorService $deudorService,
    )

    {
        $this->ruta = $ruta;
        $this->asignaturaService = $asignaturaService;
        $this->deudorService = $deudorService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (session('tipo') == 'Directivo' || session('tipo') == 'Institucion') {

            if ($this->asignaturaService->verificarInstitucionDirectivo($link[9])) {
                return $next($request);
            }
            abort(403, 'Esta asignatura no forma parte de tu institución.');
        }

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($link[9])) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de esta asignatura.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($this->asignaturaService->verificarAlumno($link[9])) {
                return $next($request);
            }
            abort(403, 'Wsta asignatura no forma parte de tu división.');
        }
        abort(403, 'No puede estar aquí.');
    }
}
